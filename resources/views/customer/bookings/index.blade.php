<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('My Bookings') }}</h2>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr><th>Booking #</th><th>Hotel</th><th>Dates</th><th>Total</th><th>Status</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><a href="{{ route('customer.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></td>
                            <td>{{ $booking->hotel->name }}</td>
                            <td>{{ $booking->check_in->format('M d, Y') }} – {{ $booking->check_out->format('M d, Y') }}</td>
                            <td>${{ number_format($booking->total_amount, 2) }}</td>
                            <td>{!! match($booking->status) {
                                'pending' => '<span class="badge bg-warning">Pending</span>',
                                'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                                'checked_in' => '<span class="badge bg-info">Checked In</span>',
                                'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                                'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                                'expired' => '<span class="badge bg-dark">Expired</span>',
                                default => '<span class="badge bg-light text-dark">'.ucfirst($booking->status).'</span>',
                            } !!}</td>
                            <td class="text-end">
                                <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No bookings yet. <a href="{{ route('search') }}">Search for rooms</a> to get started.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $bookings->links() }}</div>
</x-app-layout>
