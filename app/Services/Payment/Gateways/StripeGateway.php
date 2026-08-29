<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Payment;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeGateway implements PaymentGateway
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret_key'));
    }

    public function name(): string
    {
        return 'stripe';
    }

    public function process(array $data): PaymentResult
    {
        try {
            $intent = $this->stripe->paymentIntents->create([
                'amount' => (int) round($data['amount'] * 100),
                'currency' => strtolower($data['currency'] ?? 'usd'),
                'payment_method' => $data['payment_method_id'] ?? null,
                'confirmation_method' => 'automatic',
                'description' => $data['description'] ?? 'Hotel booking payment',
                'metadata' => [
                    'booking_id' => (string) ($data['booking_id'] ?? ''),
                    'booking_number' => $data['booking_number'] ?? '',
                ],
            ]);

            if ($intent->status === 'requires_action') {
                return new PaymentResult(
                    success: true,
                    transactionId: $intent->id,
                    message: 'requires_action',
                    metadata: ['client_secret' => $intent->client_secret, 'requires_action' => true],
                );
            }

            if ($intent->status === 'succeeded') {
                return new PaymentResult(
                    success: true,
                    transactionId: $intent->id,
                    message: 'Payment succeeded.',
                );
            }

            return new PaymentResult(
                success: false,
                transactionId: $intent->id,
                message: "Payment status: {$intent->status}",
            );
        } catch (ApiErrorException $e) {
            return new PaymentResult(
                success: false,
                message: $e->getMessage(),
            );
        }
    }

    public function refund(Payment $payment, ?float $amount = null): PaymentResult
    {
        try {
            $params = ['payment_intent' => $payment->transaction_id];
            if ($amount !== null) {
                $params['amount'] = (int) round($amount * 100);
            }

            $refund = $this->stripe->refunds->create($params);

            return new PaymentResult(
                success: $refund->status === 'succeeded',
                transactionId: $refund->id,
                message: $refund->status === 'succeeded' ? 'Refund succeeded.' : "Refund status: {$refund->status}",
            );
        } catch (ApiErrorException $e) {
            return new PaymentResult(
                success: false,
                message: $e->getMessage(),
            );
        }
    }

    public function verify(string $transactionId): PaymentResult
    {
        try {
            $intent = $this->stripe->paymentIntents->retrieve($transactionId);

            return new PaymentResult(
                success: $intent->status === 'succeeded',
                transactionId: $intent->id,
                message: "Intent status: {$intent->status}",
                metadata: [
                    'status' => $intent->status,
                    'amount' => $intent->amount / 100,
                    'currency' => strtoupper($intent->currency),
                ],
            );
        } catch (ApiErrorException $e) {
            return new PaymentResult(
                success: false,
                message: $e->getMessage(),
            );
        }
    }

    public function supportsRecurring(): bool
    {
        return false;
    }
}
