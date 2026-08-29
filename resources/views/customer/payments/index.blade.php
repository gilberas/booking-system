<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Payment — {{ $booking->booking_number }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></li>
            <li class="breadcrumb-item active">Payment</li>
        </ol>
    </nav>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header">Select Payment Method</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($gateways as $name => $gateway)
                            <a href="{{ route('customer.payments.checkout', [$booking, 'method' => $name]) }}"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">
                                        @switch($name)
                                            @case('stripe') <i class="bi bi-credit-card"></i> Credit / Debit Card @break
                                            @case('cash') <i class="bi bi-cash"></i> Cash @break
                                            @case('credit_card') <i class="bi bi-card-heading"></i> Credit Card (Offline) @break
                                            @case('paypal') <i class="bi bi-paypal"></i> PayPal @break
                                            @case('mobile_money') <i class="bi bi-phone"></i> Mobile Money @break
                                            @default {{ ucfirst(str_replace('_', ' ', $name)) }}
                                        @endswitch
                                    </h6>
                                    @if ($name === 'stripe')
                                        <small class="text-muted">Pay securely with Stripe. We do not store your card details.</small>
                                    @elseif ($name === 'cash')
                                        <small class="text-muted">Pay at the hotel during check-in.</small>
                                    @else
                                        <small class="text-muted">Processed via {{ ucfirst(str_replace('_', ' ', $name)) }}.</small>
                                    @endif
                                </div>
                                <span class="badge bg-primary rounded-pill">Pay</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Payment Summary</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-6">Booking</dt><dd class="col-sm-6">{{ $booking->booking_number }}</dd>
                        <dt class="col-sm-6">Hotel</dt><dd class="col-sm-6">{{ $booking->hotel->name }}</dd>
                        <dt class="col-sm-6">Total</dt><dd class="col-sm-6">${{ number_format($booking->total_amount, 2) }}</dd>
                        <dt class="col-sm-6">Paid</dt><dd class="col-sm-6 text-success">${{ number_format($booking->paid_amount, 2) }}</dd>
                        <hr>
                        <dt class="col-sm-6 fw-bold">Due Now</dt><dd class="col-sm-6 fw-bold text-primary">${{ number_format($due, 2) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
