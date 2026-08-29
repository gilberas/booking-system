<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Booking {{ $booking->booking_number }}</h2>
            <div class="d-flex gap-2">
                @if ($booking->invoice)
                    <a href="{{ route('customer.payments.receipt', $booking) }}" class="btn btn-outline-primary btn-sm">Receipt</a>
                @endif
                @if (!in_array($booking->status, ['cancelled', 'checked_out', 'expired']) && $booking->paid_amount < $booking->total_amount)
                    <a href="{{ route('customer.payments.index', $booking) }}" class="btn btn-success btn-sm">Pay Now</a>
                @endif
                @if ($booking->status === 'checked_out' && !$booking->review)
                    <a href="{{ route('customer.reviews.create', $booking) }}" class="btn btn-outline-warning btn-sm">Write Review</a>
                @endif
                @if ($canCancel)
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel Booking</button>
                @endif
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.bookings.index') }}">My Bookings</a></li>
            <li class="breadcrumb-item active">{{ $booking->booking_number }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{!! match($booking->status) {
                            'pending' => '<span class="badge bg-warning">Pending</span>',
                            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                            'checked_in' => '<span class="badge bg-info">Checked In</span>',
                            'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                            'expired' => '<span class="badge bg-dark">Expired</span>',
                            default => '<span class="badge bg-light text-dark">'.ucfirst($booking->status).'</span>',
                        } !!}</dd>
                        <dt class="col-sm-4">Hotel</dt><dd class="col-sm-8">{{ $booking->hotel->name }}</dd>
                        <dt class="col-sm-4">Check-in</dt><dd class="col-sm-8">{{ $booking->check_in->format('M d, Y') }} (from {{ substr($booking->hotel->check_in_time, 0, 5) }})</dd>
                        <dt class="col-sm-4">Check-out</dt><dd class="col-sm-8">{{ $booking->check_out->format('M d, Y') }} (by {{ substr($booking->hotel->check_out_time, 0, 5) }})</dd>
                        <dt class="col-sm-4">Guests</dt><dd class="col-sm-8">{{ $booking->num_guests }} ({{ $booking->adults }} adults, {{ $booking->children }} children)</dd>
                        <dt class="col-sm-4">Booked</dt><dd class="col-sm-8">{{ $booking->created_at->format('M d, Y H:i') }}</dd>
                        @if ($booking->special_requests)
                            <dt class="col-sm-4">Requests</dt><dd class="col-sm-8">{{ $booking->special_requests }}</dd>
                        @endif
                        @if ($booking->status === 'cancelled' && $booking->cancellation_reason)
                            <dt class="col-sm-4">Cancel Reason</dt><dd class="col-sm-8">{{ $booking->cancellation_reason }}</dd>
                            <dt class="col-sm-4">Cancelled At</dt><dd class="col-sm-8">{{ $booking->cancelled_at?->format('M d, Y H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Rooms</div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr><th>Room</th><th>Type</th><th>Dates</th><th>Price</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($booking->bookingRooms as $br)
                                <tr>
                                    <td>#{{ $br->room->room_number }}</td>
                                    <td>{{ $br->roomType->name }}</td>
                                    <td>{{ $br->check_in->format('M d') }} – {{ $br->check_out->format('M d') }}</td>
                                    <td>${{ number_format($br->total_price, 2) }}</td>
                                    <td>{!! match($br->status) {
                                        'pending' => '<span class="badge bg-warning">Pending</span>',
                                        'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                                        'checked_in' => '<span class="badge bg-info">Checked In</span>',
                                        'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                                        'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                                        default => '<span class="badge bg-light text-dark">'.ucfirst($br->status).'</span>',
                                    } !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Payment Summary</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Subtotal</dt><dd class="col-sm-6 text-end">${{ number_format($booking->subtotal, 2) }}</dd>
                        <dt class="col-sm-6">Tax</dt><dd class="col-sm-6 text-end">${{ number_format($booking->tax_amount, 2) }}</dd>
                        <dt class="col-sm-6 fw-bold">Total</dt><dd class="col-sm-6 text-end fw-bold">${{ number_format($booking->total_amount, 2) }}</dd>
                        <dt class="col-sm-6">Paid</dt><dd class="col-sm-6 text-end text-success">${{ number_format($booking->paid_amount, 2) }}</dd>
                        @if ($booking->status === 'cancelled' && isset($booking->refund_percentage))
                            <dt class="col-sm-6">Refund</dt><dd class="col-sm-6 text-end text-danger">{{ $booking->refund_percentage }}% (${{ number_format($booking->refund_amount, 2) }})</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if ($canCancel)
        <div class="modal fade" id="cancelModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Cancel Booking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to cancel this booking?</p>
                            <div class="alert alert-info small">
                                Refund policy: free cancellation up to 48 hours before check-in.
                                Late cancellation (within 48 hours) incurs a 50% fee.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason for cancellation</label>
                                <textarea name="cancellation_reason" class="form-control @error('cancellation_reason') is-invalid @enderror" rows="3" required minlength="10">{{ old('cancellation_reason') }}</textarea>
                                @error('cancellation_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keep Booking</button>
                            <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
