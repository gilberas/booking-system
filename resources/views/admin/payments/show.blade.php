<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Payment Details — {{ $payment->transaction_id ?? 'N/A' }}</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <dl class="row mb-0 small">
                <dt class="col-sm-3">Transaction</dt><dd class="col-sm-9">{{ $payment->transaction_id ?? '—' }}</dd>
                <dt class="col-sm-3">Booking</dt><dd class="col-sm-9"><a href="{{ route('admin.manage-bookings.show', $payment->booking) }}">{{ $payment->booking?->booking_number ?? '—' }}</a></dd>
                <dt class="col-sm-3">Customer</dt><dd class="col-sm-9">{{ $payment->user?->name ?? '—' }}</dd>
                <dt class="col-sm-3">Method</dt><dd class="col-sm-9">{{ ucfirst(str_replace('_',' ',$payment->payment_method)) }}</dd>
                <dt class="col-sm-3">Amount</dt><dd class="col-sm-9">${{ number_format($payment->amount, 2) }}</dd>
                <dt class="col-sm-3">Currency</dt><dd class="col-sm-9">{{ $payment->currency }}</dd>
                <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><span class="badge bg-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($payment->status) }}</span></dd>
                <dt class="col-sm-3">Paid At</dt><dd class="col-sm-9">{{ $payment->paid_at?->format('M d, Y H:i') ?? '—' }}</dd>
                @if ($payment->invoice)<dt class="col-sm-3">Invoice</dt><dd class="col-sm-9">{{ $payment->invoice->invoice_number }}</dd>@endif
                @if ($payment->notes)<dt class="col-sm-3">Notes</dt><dd class="col-sm-9">{{ $payment->notes }}</dd>@endif
            </dl>
        </div>
    </div>
</x-app-layout>
