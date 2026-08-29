<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Payment;
use Illuminate\Support\Str;

class PayPalGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'paypal';
    }

    public function process(array $data): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'PP-'.strtoupper(Str::random(14)),
            message: 'PayPal payment processed.',
        );
    }

    public function refund(Payment $payment, ?float $amount = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'PP-REFUND-'.strtoupper(Str::random(14)),
            message: 'PayPal refund processed.',
        );
    }

    public function verify(string $transactionId): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: $transactionId,
            message: 'PayPal payment verified.',
        );
    }

    public function supportsRecurring(): bool
    {
        return false;
    }
}
