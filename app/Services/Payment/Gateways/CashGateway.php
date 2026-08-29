<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Payment;
use Illuminate\Support\Str;

class CashGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'cash';
    }

    public function process(array $data): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'CASH-'.strtoupper(Str::random(10)),
            message: 'Cash payment recorded at checkout.',
        );
    }

    public function refund(Payment $payment, ?float $amount = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: 'CASH-REFUND-'.strtoupper(Str::random(10)),
            message: 'Cash refund processed at checkout.',
        );
    }

    public function verify(string $transactionId): PaymentResult
    {
        return new PaymentResult(
            success: true,
            transactionId: $transactionId,
            message: 'Cash payments are verified offline.',
        );
    }

    public function supportsRecurring(): bool
    {
        return false;
    }
}
