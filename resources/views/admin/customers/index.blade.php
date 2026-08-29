<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0"><i class="bi bi-people me-2"></i>Customers</h2>
    </x-slot>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            <button class="btn btn-navy"><i class="bi bi-search"></i> Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th class="text-end">Bookings</th><th>Joined</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($customers as $c)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-navy text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;font-size:.7rem;font-weight:600;">
                                            {{ substr($c->name, 0, 1) }}
                                        </div>
                                        <a href="{{ route('admin.customers.show', $c) }}" class="fw-bold text-decoration-none">{{ $c->name }}</a>
                                    </div>
                                </td>
                                <td><small>{{ $c->email }}</small></td>
                                <td>{{ $c->phone ?? '—' }}</td>
                                <td class="text-end"><span class="badge-status bg-active">{{ $c->bookings_count }}</span></td>
                                <td><small>{{ $c->created_at->format('M d, Y') }}</small></td>
                                <td class="text-end"><a href="{{ route('admin.customers.show', $c) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-people d-block mb-1" style="font-size:1.5rem;"></i>No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $customers->links() }}</div>
</x-app-layout>
