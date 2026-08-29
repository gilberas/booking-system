<?php

namespace App\Repositories\Payment;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentRepository
{
    public function createPayment(array $data): Payment
    {
        return Payment::create($data);
    }

    public function updatePayment(Payment $payment, array $data): bool
    {
        return $payment->update($data);
    }

    public function createInvoice(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $timestamp = now()->format('ymdHis');
        $random = strtoupper(Str::random(4));

        return "{$prefix}-{$timestamp}-{$random}";
    }
}
