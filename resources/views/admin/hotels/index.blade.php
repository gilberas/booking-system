<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-building me-2"></i>Hotels</h2>
            <a href="{{ route('admin.hotels.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Hotel</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr><th>Name</th><th>City</th><th>Country</th><th>Stars</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($hotels as $hotel)
                            <tr>
                                <td><a href="{{ route('admin.hotels.show', $hotel) }}" class="fw-bold text-decoration-none">{{ $hotel->name }}</a></td>
                                <td>{{ $hotel->city }}</td>
                                <td>{{ $hotel->country }}</td>
                                <td><span class="text-gold">{{ str_repeat('★', $hotel->star_rating) }}</span></td>
                                <td><span class="badge-status bg-{{ $hotel->is_active ? 'active' : 'inactive' }}">{{ $hotel->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('admin.hotels.room-types.index', $hotel) }}" class="btn btn-sm btn-outline-gold"><i class="bi bi-door-open"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-building d-block mb-1" style="font-size:1.5rem;"></i>No hotels found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $hotels->links() }}</div>
</x-app-layout>
