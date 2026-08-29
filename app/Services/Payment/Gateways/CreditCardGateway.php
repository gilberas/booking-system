<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Payment;
use Illuminate\Support\Str;

class CreditCardGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'credit_card';
    }

    public function process(array $data): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'CC-'.strtoupper(Str::random(16)),
            message: 'Credit card payment processed.',
        );
    }

    public function refund(Payment $payment, ?float $amount = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'CC-REFUND-'.strtoupper(Str::random(16)),
            message: 'Credit card refund processed.',
        );
    }

    public function verify(string $transactionId): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: $transactionId,
            message: 'Credit card payment verified.',
        );
    }

    public function supportsRecurring(): bool
    {
        return false;
    }
}
