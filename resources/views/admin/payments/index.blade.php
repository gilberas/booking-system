<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Payments</h2></x-slot>
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-auto"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()"><option value="">All Statuses</option>@foreach(['pending','paid','failed','refunded'] as $s)<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
            <div class="col-auto"><select name="method" class="form-select form-select-sm" onchange="this.form.submit()"><option value="">All Methods</option>@foreach(['stripe','cash','credit_card','paypal','mobile_money'] as $m)<option value="{{ $m }}" {{ request('method')==$m?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$m)) }}</option>@endforeach</select></div>
        </div>
    </form>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Transaction</th><th>Booking</th><th>Method</th><th class="text-end">Amount</th><th>Status</th><th>Date</th><th></th></tr></thead>
                <tbody>
                    @forelse ($payments as $p)
                        <tr>
                            <td><small>{{ $p->transaction_id ?? '—' }}</small></td>
                            <td><a href="{{ route('admin.manage-bookings.show', $p->booking) }}">{{ $p->booking?->booking_number ?? '—' }}</a></td>
                            <td>{{ ucfirst(str_replace('_',' ',$p->payment_method)) }}</td>
                            <td class="text-end">${{ number_format($p->amount, 2) }}</td>
                            <td><span class="badge bg-{{ $p->status === 'paid' ? 'success' : ($p->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($p->status) }}</span></td>
                            <td><small>{{ $p->created_at->format('M d, Y H:i') }}</small></td>
                            <td class="text-end"><a href="{{ route('admin.payments.show', $p) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $payments->links() }}</div>
</x-app-layout>
