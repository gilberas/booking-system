<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-grid-3x3-gap me-2"></i>Amenities</h2>
            <a href="{{ route('admin.amenities.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Amenity</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Name</th><th>Category</th><th>Icon</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($amenities as $amenity)
                            <tr>
                                <td><a href="{{ route('admin.amenities.show', $amenity) }}" class="fw-bold text-decoration-none">{{ $amenity->name }}</a></td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($amenity->category) }}</span></td>
                                <td><code>{{ $amenity->icon ?? '—' }}</code></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-grid-3x3-gap d-block mb-1" style="font-size:1.5rem;"></i>No amenities found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $amenities->links() }}</div>
</x-app-layout>
