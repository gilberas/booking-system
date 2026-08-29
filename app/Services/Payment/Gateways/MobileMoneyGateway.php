<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Payment;
use Illuminate\Support\Str;

class MobileMoneyGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'mobile_money';
    }

    public function process(array $data): PaymentResult
    {
        $phone = $data['phone_number'] ?? 'unknown';

        return new PaymentResult(
            success: true,
            transactionId: 'MM-'.strtoupper(Str::random(12)),
            message: "Payment request sent to {$phone}. Complete payment on your mobile device.",
        );
    }

    public function refund(Payment $payment, ?float $amount = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'MM-REFUND-'.strtoupper(Str::random(12)),
            message: 'Mobile money refund processed.',
        );
    }

    public function verify(string $transactionId): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: $transactionId,
            message: 'Mobile money payment verified.',
        );
    }

    public function supportsRecurring(): bool
    {
        return false;
    }
}
