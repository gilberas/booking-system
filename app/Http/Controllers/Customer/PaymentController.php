<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Payment\PaymentService;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService
    ) {}

    public function index(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 404);

        if (in_array($booking->status, ['cancelled', 'checked_out', 'expired'])) {
            abort(404);
        }

        $due = $booking->total_amount - $booking->paid_amount;
        if ($due <= 0) {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('info', 'This booking has been fully paid.');
        }

        $gateways = $this->paymentService->getAvailableGateways();

        return view('customer.payments.index', compact('booking', 'due', 'gateways'));
    }

    public function checkout(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 404);

        if (in_array($booking->status, ['cancelled', 'checked_out', 'expired'])) {
            abort(404);
        }

        $due = $booking->total_amount - $booking->paid_amount;
        if ($due <= 0) {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('info', 'This booking has been fully paid.');
        }

        $method = request('method', 'stripe');
        $gateway = $this->paymentService->getGateway($method);

        if ($method === 'stripe') {
            $intent = null;
            try {
                $stripe = new StripeClient(config('services.stripe.secret_key'));
                $intent = $stripe->paymentIntents->create([
                    'amount' => (int) round($due * 100),
                    'currency' => strtolower($booking->currency),
                    'description' => "Booking {$booking->booking_number}",
                    'metadata' => ['booking_id' => (string) $booking->id],
                ]);
            } catch (\Exception $e) {
                return back()->with('error', 'Payment service unavailable. Please try again.');
            }

            return view('customer.payments.stripe-checkout', compact('booking', 'due', 'intent'));
        }

        $result = $this->paymentService->processPayment($booking, $method, request()->all());

        if ($result->success) {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        }

        return redirect()->route('customer.payments.index', $booking)
            ->with('error', 'Payment failed: '.$result->message);
    }

    public function confirm(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 404);

        $request = request();
        $paymentIntentId = $request->input('payment_intent');
        $redirectStatus = $request->input('redirect_status');

        if (! $paymentIntentId) {
            return redirect()->route('customer.payments.index', $booking)
                ->with('error', 'No payment intent provided.');
        }

        if ($redirect_status === 'succeeded') {
            $result = $this->paymentService->confirmStripePayment($booking, $paymentIntentId);

            if ($result->success) {
                return redirect()->route('customer.bookings.show', $booking)
                    ->with('success', 'Payment successful! Your booking is confirmed.');
            }
        }

        return redirect()->route('customer.payments.index', $booking)
            ->with('error', 'Payment was not completed. Please try again.');
    }

    public function receipt(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 404);

        $invoice = $booking->invoice;
        abort_if(! $invoice, 404, 'No invoice available for this booking.');

        $invoice->load('payments');

        return view('customer.payments.receipt', compact('booking', 'invoice'));
    }
}
