<x-app-layout>
    <x-slot name="header"><div class="d-flex justify-content-between"><h2 class="h4 mb-0">Discounts</h2><a href="{{ route('admin.discounts.create') }}" class="btn btn-navy btn-sm">+ New Discount</a></div></x-slot>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Code</th><th>Name</th><th>Type</th><th class="text-end">Value</th><th class="text-end">Uses</th><th>Valid</th><th>Active</th><th></th></tr></thead>
                <tbody>
                    @forelse ($discounts as $d)
                        <tr>
                            <td><strong>{{ $d->code }}</strong></td>
                            <td>{{ $d->name }}</td>
                            <td>{{ ucfirst($d->type) }}</td>
                            <td class="text-end">{{ $d->type === 'percentage' ? $d->value.'%' : '$'.number_format($d->value,2) }}</td>
                            <td class="text-end">{{ $d->used_count }}{{ $d->max_uses ? '/'.$d->max_uses : '' }}</td>
                            <td>{!! $d->isValid() ? '<span class="badge bg-success">Valid</span>' : '<span class="badge bg-secondary">Expired</span>' !!}</td>
                            <td>{!! $d->is_active ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>' !!}</td>
                            <td class="text-end"><a href="{{ route('admin.discounts.edit', $d) }}" class="btn btn-sm btn-outline-navy">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No discounts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $discounts->links() }}</div>
</x-app-layout>
