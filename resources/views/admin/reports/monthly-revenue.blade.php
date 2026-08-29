<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Monthly Revenue</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Month</th><th class="text-end">Revenue</th><th class="text-end">Transactions</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr><td>{{ $r['month'] }}</td><td class="text-end">${{ number_format($r['revenue'], 2) }}</td><td class="text-end">{{ $r['transactions'] }}</td></tr>
                    @endforeach
                </tbody>
                <tfoot><tr class="fw-bold"><td>Total</td><td class="text-end">${{ number_format($total, 2) }}</td><td class="text-end">{{ $records->sum('transactions') }}</td></tr></tfoot>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2 small">Avg ${{ number_format($avgPerMonth, 2) }}/month</p>
</x-app-layout>
