<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService
    ) {}

    public function handleStripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        if ($endpointSecret) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } catch (SignatureVerificationException) {
                return response()->json(['error' => 'Invalid signature.'], 403);
            }
        } else {
            $event = json_decode($payload);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            case 'charge.refunded':
                $this->handleChargeRefunded($event->data->object);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentIntentSucceeded(PaymentIntent $intent): void
    {
        $bookingId = $intent->metadata->booking_id ?? null;
        if (! $bookingId) {
            return;
        }

        $booking = Booking::find($bookingId);
        if (! $booking) {
            return;
        }

        $this->paymentService->confirmStripePayment($booking, $intent->id);
    }

    private function handlePaymentIntentFailed(PaymentIntent $intent): void
    {
        $bookingId = $intent->metadata->booking_id ?? null;
        if (! $bookingId) {
            return;
        }

        $payment = Payment::where('transaction_id', $intent->id)->first();
        if ($payment && $payment->status === 'pending') {
            $payment->update([
                'status' => 'failed',
                'notes' => $intent->last_payment_error?->message ?? 'Payment failed.',
            ]);
        }
    }

    private function handleChargeRefunded(Charge $charge): void
    {
        $payment = Payment::where('transaction_id', $charge->payment_intent)->first();
        if ($payment && $payment->status === 'paid') {
            $this->paymentService->processRefund($payment, $charge->amount_refunded / 100);
        }
    }
}
