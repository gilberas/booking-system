<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-door-open me-2"></i>Room Types — {{ $hotel->name }}</h2>
            <a href="{{ route('admin.hotels.room-types.create', $hotel) }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Room Type</a>
        </div>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item active">{{ $hotel->name }}</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Name</th><th>Occupancy</th><th>Bed</th><th>Price</th><th>Rooms</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($roomTypes as $rt)
                            <tr>
                                <td><a href="{{ route('admin.hotels.room-types.show', [$hotel, $rt]) }}" class="fw-bold text-decoration-none">{{ $rt->name }}</a></td>
                                <td><i class="bi bi-people me-1"></i>{{ $rt->max_occupancy }}</td>
                                <td>{{ $rt->num_beds }} × {{ ucfirst($rt->bed_type) }}</td>
                                <td><strong>${{ number_format($rt->base_price, 2) }}</strong></td>
                                <td><span class="badge bg-light text-dark">{{ $rt->num_rooms_total }} rooms</span></td>
                                <td><span class="badge-status bg-{{ $rt->is_active ? 'active' : 'inactive' }}">{{ $rt->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.hotels.room-types.edit', [$hotel, $rt]) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('admin.hotels.room-types.rooms.index', [$hotel, $rt]) }}" class="btn btn-sm btn-outline-gold"><i class="bi bi-grid-3x3-gap"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No room types found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $roomTypes->links() }}</div>
</x-app-layout>
