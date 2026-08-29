<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-grid-3x3-gap me-2"></i>Rooms — {{ $roomType->name }} ({{ $hotel->name }})</h2>
            <a href="{{ route('admin.hotels.room-types.rooms.create', [$hotel, $roomType]) }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Room</a>
        </div>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.index', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item active">{{ $roomType->name }} &middot; Rooms</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Room #</th><th>Floor</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr>
                                <td class="fw-bold">{{ $room->room_number }}</td>
                                <td>Floor {{ $room->floor }}</td>
                                <td>
                                    @php $statusMap = ['available' => 'active', 'occupied' => 'pending', 'maintenance' => 'inactive', 'reserved' => 'confirmed']; @endphp
                                    <span class="badge-status bg-{{ $statusMap[$room->status] ?? 'expired' }}">{{ ucfirst($room->status) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.hotels.room-types.rooms.edit', [$hotel, $roomType, $room]) }}" class="btn btn-sm btn-outline-navy"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-door-open d-block mb-1" style="font-size:1.5rem;"></i>No rooms found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $rooms->links() }}</div>
</x-app-layout>
