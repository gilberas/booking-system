<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Payment Report</h2></x-slot>
    @include('admin.reports._filters')
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card"><div class="card-body"><h5 class="mb-0">${{ number_format($total, 2) }}</h5><small class="text-muted">Total Payments</small></div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                @foreach ($byMethod as $method => $amount)
                    <div class="d-flex justify-content-between"><span>{{ ucfirst(str_replace('_', ' ', $method)) }}</span><span>${{ number_format($amount, 2) }}</span></div>
                @endforeach
                <small class="text-muted">By Method</small>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                @foreach ($byStatus as $status => $amount)
                    <div class="d-flex justify-content-between"><span>{{ ucfirst($status) }}</span><span>${{ number_format($amount, 2) }}</span></div>
                @endforeach
                <small class="text-muted">By Status</small>
            </div></div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Transaction</th><th>Booking</th><th>Method</th><th class="text-end">Amount</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td><small>{{ $r->transaction_id ?? '—' }}</small></td>
                            <td>{{ $r->booking?->booking_number ?? '—' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $r->payment_method)) }}</td>
                            <td class="text-end">${{ number_format($r->amount, 2) }}</td>
                            <td><span class="badge bg-{{ $r->status === 'paid' ? 'success' : ($r->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($r->status) }}</span></td>
                            <td>{{ $r->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
