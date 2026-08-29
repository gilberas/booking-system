<?php

namespace App\Contracts;

use App\Models\Payment;

class PaymentResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $transactionId = null,
        public readonly ?string $message = null,
        public readonly ?array $metadata = null,
    ) {}
}

interface PaymentGateway
{
    public function name(): string;

    public function process(array $data): PaymentResult;

    public function refund(Payment $payment, ?float $amount = null): PaymentResult;

    public function verify(string $transactionId): PaymentResult;

    public function supportsRecurring(): bool;
}
