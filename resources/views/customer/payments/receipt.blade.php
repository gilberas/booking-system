<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Receipt — {{ $booking->booking_number }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></li>
            <li class="breadcrumb-item active">Receipt</li>
        </ol>
    </nav>

    <div class="card mb-4" id="receipt">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Invoice #{{ $invoice->invoice_number }}</span>
            <span class="badge bg-success">Paid</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-6">
                    <h6>Hotel</h6>
                    <p class="mb-0">{{ $booking->hotel->name }}<br>
                    {{ $booking->hotel->address }}<br>
                    {{ $booking->hotel->city }}, {{ $booking->hotel->country }}</p>
                </div>
                <div class="col-6 text-end">
                    <h6>Customer</h6>
                    <p class="mb-0">{{ $booking->user->name }}<br>
                    {{ $booking->user->email }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <small class="text-muted">Invoice Date</small><br>
                    {{ $invoice->invoice_date->format('M d, Y') }}
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Due Date</small><br>
                    {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr><th>Description</th><th class="text-end">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach ($booking->bookingRooms as $br)
                        <tr>
                            <td>{{ $br->roomType->name }} — Room #{{ $br->room->room_number }}<br>
                                <small class="text-muted">{{ $br->check_in->format('M d') }} – {{ $br->check_out->format('M d') }} · ${{ number_format($br->price_per_night, 2) }}/night</small>
                            </td>
                            <td class="text-end">${{ number_format($br->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><td>Subtotal</td><td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td></tr>
                    <tr><td>Tax ({{ $invoice->tax_percentage }}%)</td><td class="text-end">${{ number_format($invoice->tax_amount, 2) }}</td></tr>
                    <tr class="fw-bold"><td>Total</td><td class="text-end">${{ number_format($invoice->total, 2) }}</td></tr>
                    <tr><td>Paid</td><td class="text-end text-success">${{ number_format($booking->paid_amount, 2) }}</td></tr>
                </tfoot>
            </table>

            <div class="row">
                <div class="col-6">
                    <h6>Payments</h6>
                    <ul class="list-unstyled small">
                        @forelse ($invoice->payments as $payment)
                            <li>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} — ${{ number_format($payment->amount, 2) }}
                                @if ($payment->paid_at)
                                    <br><span class="text-muted">{{ $payment->paid_at->format('M d, Y H:i') }}</span>
                                @endif
                            </li>
                        @empty
                            <li class="text-muted">No payment records.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Booking #{{ $booking->booking_number }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <button class="btn btn-primary" onclick="window.print()">Print Receipt</button>
        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-secondary">Back to Booking</a>
    </div>

    @push('styles')
    <style>
        @@media print {
            nav, .btn, header, .breadcrumb { display: none !important; }
            #receipt { border: none !important; box-shadow: none !important; }
            .card-header { background: #f8f9fa !important; }
        }
    </style>
    @endpush
</x-app-layout>
