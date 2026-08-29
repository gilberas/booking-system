<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Room {{ $room->room_number }} — {{ $roomType->name }}</h2>
            <a href="{{ route('admin.hotels.room-types.rooms.edit', [$hotel, $roomType, $room]) }}" class="btn btn-sm btn-outline-navy">Edit</a>
        </div>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.index', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.show', [$hotel, $roomType]) }}">{{ $roomType->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.rooms.index', [$hotel, $roomType]) }}">Rooms</a></li>
            <li class="breadcrumb-item active">{{ $room->room_number }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Room Number</dt><dd class="col-sm-9">{{ $room->room_number }}</dd>
                <dt class="col-sm-3">Floor</dt><dd class="col-sm-9">{{ $room->floor }}</dd>
                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{!! match($room->status) {
                    'available' => '<span class="badge bg-success">Available</span>',
                    'occupied' => '<span class="badge bg-warning">Occupied</span>',
                    'maintenance' => '<span class="badge bg-danger">Maintenance</span>',
                    'reserved' => '<span class="badge bg-info">Reserved</span>',
                    default => '<span class="badge bg-secondary">'.ucfirst($room->status).'</span>',
                } !!}</dd>
                @if ($room->notes)
                    <dt class="col-sm-3">Notes</dt><dd class="col-sm-9">{{ $room->notes }}</dd>
                @endif
            </dl>
        </div>
    </div>
</x-app-layout>
