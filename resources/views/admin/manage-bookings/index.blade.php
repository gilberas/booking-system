<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Manage Bookings</h2></x-slot>
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-auto"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()"><option value="">All Statuses</option>@foreach(['pending','confirmed','checked_in','checked_out','cancelled','expired'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
            <div class="col"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search booking #, customer, hotel..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-navy">Filter</button></div>
        </div>
    </form>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Booking #</th><th>Customer</th><th>Hotel</th><th>Dates</th><th class="text-end">Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($bookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.manage-bookings.show', $b) }}">{{ $b->booking_number }}</a></td>
                            <td>{{ $b->user->name }}</td>
                            <td>{{ $b->hotel->name }}</td>
                            <td><small>{{ $b->check_in->format('M d') }} – {{ $b->check_out->format('M d, Y') }}</small></td>
                            <td class="text-end">${{ number_format($b->total_amount, 2) }}</td>
                            <td>{!! match($b->status) {
                                'pending' => '<span class="badge bg-warning">Pending</span>',
                                'confirmed' => '<span class="badge bg-success">Confirmed</span>',
                                'checked_in' => '<span class="badge bg-info">Checked In</span>',
                                'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
                                'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                                'expired' => '<span class="badge bg-dark">Expired</span>',
                                default => '<span class="badge bg-light text-dark">'.ucfirst($b->status).'</span>',
                            } !!}</td>
                            <td class="text-end"><a href="{{ route('admin.manage-bookings.show', $b) }}" class="btn btn-sm btn-outline-navy">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No bookings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $bookings->links() }}</div>
</x-app-layout>
