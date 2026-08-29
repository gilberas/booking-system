<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Cancelled Bookings</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Booking #</th><th>Customer</th><th>Hotel</th><th>Total</th><th>Cancelled At</th><th>Reason</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td><a href="{{ route('admin.manage-bookings.show', $r) }}">{{ $r->booking_number }}</a></td>
                            <td>{{ $r->user->name }}</td>
                            <td>{{ $r->hotel->name }}</td>
                            <td>${{ number_format($r->total_amount, 2) }}</td>
                            <td>{{ $r->cancelled_at?->format('M d, Y H:i') }}</td>
                            <td><small>{{ Str::limit($r->cancellation_reason, 50) }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2 small">{{ $total }} cancelled · ${{ number_format($totalRevenue, 2) }} total value</p>
</x-app-layout>
