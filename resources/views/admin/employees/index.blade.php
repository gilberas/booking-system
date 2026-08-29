<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-people me-2"></i>Employees</h2>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Employee</a>
        </div>
    </x-slot>

    <form method="GET" class="mb-3">
        <select name="hotel_id" class="form-select form-select-sm w-auto shadow-sm" onchange="this.form.submit()">
            <option value="">All Hotels</option>
            @foreach ($hotels as $h)
                <option value="{{ $h->id }}" {{ request('hotel_id') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Code</th><th>Name</th><th>Position</th><th>Hotel</th><th>Hire Date</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($employees as $e)
                            <tr>
                                <td><code>{{ $e->employee_code }}</code></td>
                                <td><a href="{{ route('admin.employees.show', $e) }}" class="fw-bold text-decoration-none">{{ $e->user->name }}</a></td>
                                <td>{{ $e->position ?? '—' }}</td>
                                <td>{{ $e->hotel?->name ?? '—' }}</td>
                                <td><small>{{ $e->hire_date?->format('M d, Y') ?? '—' }}</small></td>
                                <td><span class="badge-status bg-{{ $e->is_active ? 'active' : 'inactive' }}">{{ $e->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td class="text-end"><a href="{{ route('admin.employees.edit', $e) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-pencil"></i></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-people d-block mb-1" style="font-size:1.5rem;"></i>No employees found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $employees->links() }}</div>
</x-app-layout>
