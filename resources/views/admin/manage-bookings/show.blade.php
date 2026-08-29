<x-app-layout>
    <x-slot name="header"><div class="d-flex justify-content-between"><h2 class="h4 mb-0">Booking {{ $booking->booking_number }}</h2></div></x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-3">Customer</dt><dd class="col-sm-9">{{ $booking->user->name }} ({{ $booking->user->email }})</dd>
                        <dt class="col-sm-3">Hotel</dt><dd class="col-sm-9">{{ $booking->hotel->name }}</dd>
                        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{!! match($booking->status) {
                            'pending' => '<span class="badge bg-warning">Pending</span>',
                            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                            'checked_in' => '<span class="badge bg-info">Checked In</span>',
                            'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                            'expired' => '<span class="badge bg-dark">Expired</span>',
                            default => '<span class="badge bg-light text-dark">'.ucfirst($booking->status).'</span>',
                        } !!}</dd>
                        <dt class="col-sm-3">Check-in</dt><dd class="col-sm-9">{{ $booking->check_in->format('M d, Y') }}</dd>
                        <dt class="col-sm-3">Check-out</dt><dd class="col-sm-9">{{ $booking->check_out->format('M d, Y') }}</dd>
                        <dt class="col-sm-3">Guests</dt><dd class="col-sm-9">{{ $booking->num_guests }} ({{ $booking->adults }} adults, {{ $booking->children }} children)</dd>
                        @if ($booking->special_requests)<dt class="col-sm-3">Requests</dt><dd class="col-sm-9">{{ $booking->special_requests }}</dd>@endif
                        @if ($booking->cancellation_reason)<dt class="col-sm-3">Cancel Reason</dt><dd class="col-sm-9">{{ $booking->cancellation_reason }}<br><small>{{ $booking->cancelled_at?->format('M d, Y H:i') }}</small></dd>@endif
                    </dl>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">Rooms</div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Room</th><th>Type</th><th>Nights</th><th class="text-end">Price</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach ($booking->bookingRooms as $br)
                                <tr><td>#{{ $br->room->room_number }}</td><td>{{ $br->roomType->name }}</td><td>{{ $br->check_in->diffInDays($br->check_out) }}</td><td class="text-end">${{ number_format($br->total_price, 2) }}</td><td><span class="badge bg-{{ $br->status === 'confirmed' ? 'success' : 'warning' }}">{{ ucfirst($br->status) }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Update Status</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.manage-bookings.update-status', $booking) }}">
                        @csrf
                        <select name="status" class="form-select mb-2">
                            @foreach(['pending','confirmed','checked_in','checked_out','cancelled','expired'] as $s)
                                <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-navy w-100 btn-sm">Update</button>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">Payment</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-6">Total</dt><dd class="col-sm-6 text-end">${{ number_format($booking->total_amount, 2) }}</dd>
                        <dt class="col-sm-6">Paid</dt><dd class="col-sm-6 text-end text-success">${{ number_format($booking->paid_amount, 2) }}</dd>
                        @if ($booking->invoice)<dt class="col-sm-6">Invoice</dt><dd class="col-sm-6 text-end">{{ $booking->invoice->invoice_number }}</dd>@endif
                    </dl>
                    @if ($booking->payments->isNotEmpty())
                        <hr>
                        <small>Payments:</small>
                        @foreach ($booking->payments as $p)
                            <div class="d-flex justify-content-between small"><span>{{ ucfirst(str_replace('_',' ',$p->payment_method)) }}</span><span class="badge bg-{{ $p->status === 'paid' ? 'success' : 'warning' }}">${{ number_format($p->amount, 2) }}</span></div>
                        @endforeach
                    @endif
                </div>
            </div>
            @if ($booking->review)
                <div class="card">
                    <div class="card-header">Review</div>
                    <div class="card-body small">
                        <strong>{{ $booking->review->rating }}★</strong> {{ $booking->review->title }}<br>{{ Str::limit($booking->review->body, 100) }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
