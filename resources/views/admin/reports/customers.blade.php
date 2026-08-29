<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Customer Report</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Name</th><th>Email</th><th class="text-end">Bookings</th><th class="text-end">Total Spent</th><th class="text-end">Reviews</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr><td>{{ $r->name }}</td><td>{{ $r->email }}</td><td class="text-end">{{ $r->bookings_count }}</td><td class="text-end">${{ number_format($r->bookings_sum_total_amount ?? 0, 2) }}</td><td class="text-end">{{ $r->reviews_count }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2 small">{{ $total }} total customers · {{ $active }} active</p>
</x-app-layout>
