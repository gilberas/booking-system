<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Daily Bookings</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Date</th><th class="text-end">Total Bookings</th><th class="text-end">Cancelled</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr><td>{{ $r->date }}</td><td class="text-end">{{ $r->total }}</td><td class="text-end">{{ $r->cancelled }}</td></tr>
                    @endforeach
                </tbody>
                <tfoot><tr class="fw-bold"><td>Totals</td><td class="text-end">{{ $total }}</td><td class="text-end">{{ $records->sum('cancelled') }}</td></tr></tfoot>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2 small">Avg {{ number_format($avgPerDay, 1) }} bookings/day</p>
</x-app-layout>
