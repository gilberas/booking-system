<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Booking;
use App\Models\Payment;
use App\Notifications\PaymentReceipt;
use App\Repositories\Payment\PaymentRepository;
use App\Services\Audit\AuditLogService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PaymentService
{
    private array $gateways = [];

    public function __construct(
        private readonly PaymentRepository $repository,
        private readonly DatabaseManager $db,
        private readonly AuditLogService $auditLog,
    ) {}

    public function registerGateway(string $name, PaymentGateway $gateway): void
    {
        $this->gateways[$name] = $gateway;
    }

    public function getGateway(?string $name = null): PaymentGateway
    {
        if ($name === null) {
            $name = 'stripe';
        }

        if (! isset($this->gateways[$name])) {
            throw new RuntimeException("Payment gateway '{$name}' is not registered.");
        }

        return $this->gateways[$name];
    }

    public function getAvailableGateways(): array
    {
        return $this->gateways;
    }

    public function processPayment(Booking $booking, string $method, array $gatewayData = []): PaymentResult
    {
        $gateway = $this->getGateway($method);

        return DB::transaction(function () use ($booking, $method, $gateway, $gatewayData) {
            $result = $gateway->process(array_merge($gatewayData, [
                'amount' => $booking->total_amount - $booking->paid_amount,
                'currency' => $booking->currency,
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'description' => "Booking {$booking->booking_number} - {$booking->hotel->name}",
            ]));

            $payment = $this->repository->createPayment([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'payment_method' => $method,
                'transaction_id' => $result->transactionId,
                'amount' => $booking->total_amount - $booking->paid_amount,
                'currency' => $booking->currency,
                'status' => $result->success ? 'paid' : 'failed',
                'paid_at' => $result->success ? now() : null,
                'notes' => $result->message,
            ]);

            if ($result->success) {
                $this->handleSuccessfulPayment($booking, $payment);
            }

            $this->auditLog->log('payment_processed', $payment, [
                'booking_id' => $booking->id,
                'method' => $method,
                'amount' => $payment->amount,
                'success' => $result->success,
                'transaction_id' => $result->transactionId,
            ]);

            return $result;
        });
    }

    public function processRefund(Payment $payment, ?float $amount = null): PaymentResult
    {
        if ($payment->status !== 'paid') {
            throw new RuntimeException('Only paid payments can be refunded.');
        }

        $gateway = $this->getGateway($payment->payment_method);

        return DB::transaction(function () use ($payment, $amount, $gateway) {
            $result = $gateway->refund($payment, $amount);

            if ($result->success) {
                $this->repository->updatePayment($payment, [
                    'status' => 'refunded',
                    'notes' => $payment->notes.PHP_EOL."Refunded: {$result->message}",
                ]);

                $booking = $payment->booking;
                $refundAmount = $amount ?? $payment->amount;
                $newPaid = max(0, $booking->paid_amount - $refundAmount);
                $booking->update(['paid_amount' => $newPaid]);

                $this->auditLog->log('payment_refunded', $payment, [
                    'booking_id' => $booking->id,
                    'refund_amount' => $refundAmount,
                    'original_amount' => $payment->amount,
                ]);
            }

            return $result;
        });
    }

    public function handleSuccessfulPayment(Booking $booking, Payment $payment): void
    {
        $newPaid = $booking->paid_amount + $payment->amount;
        $booking->update(['paid_amount' => $newPaid]);

        if (abs($newPaid - $booking->total_amount) < 0.01) {
            $booking->update(['status' => 'confirmed']);
            $booking->bookingRooms()->update(['status' => 'confirmed']);

            $this->auditLog->log('booking_confirmed_by_payment', $booking, [
                'paid_amount' => $newPaid,
                'total_amount' => $booking->total_amount,
            ]);
        }

        if (! $booking->invoice) {
            $this->generateInvoice($booking);
        }

        $booking->load('user');
        $booking->user->notify(new PaymentReceipt($payment));
    }

    public function generateInvoice(Booking $booking): void
    {
        $invoice = $this->repository->createInvoice([
            'booking_id' => $booking->id,
            'invoice_number' => $this->repository->generateInvoiceNumber(),
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => $booking->subtotal,
            'tax_percentage' => 10,
            'tax_amount' => $booking->tax_amount,
            'total' => $booking->total_amount,
            'status' => 'paid',
        ]);

        $booking->payments()->where('status', 'paid')->update(['invoice_id' => $invoice->id]);
    }

    public function confirmStripePayment(Booking $booking, string $paymentIntentId): PaymentResult
    {
        $gateway = $this->getGateway('stripe');
        $result = $gateway->verify($paymentIntentId);

        if ($result->success) {
            $payment = $booking->payments()
                ->where('transaction_id', $paymentIntentId)
                ->first();

            if ($payment && $payment->status === 'pending') {
                DB::transaction(function () use ($payment, $booking) {
                    $this->repository->updatePayment($payment, [
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                    $this->handleSuccessfulPayment($booking, $payment);
                });
            }
        }

        return $result;
    }
}
