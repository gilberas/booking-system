<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $roomType->name }}</h2>
            <div>
                <a href="{{ route('admin.hotels.room-types.edit', [$hotel, $roomType]) }}" class="btn btn-sm btn-outline-navy">Edit</a>
                <a href="{{ route('admin.hotels.room-types.rooms.index', [$hotel, $roomType]) }}" class="btn btn-sm btn-outline-navy">Rooms</a>
            </div>
        </div>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.index', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item active">{{ $roomType->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Hotel</dt><dd class="col-sm-8">{{ $hotel->name }}</dd>
                        <dt class="col-sm-4">Occupancy</dt><dd class="col-sm-8">{{ $roomType->max_occupancy }} guests</dd>
                        <dt class="col-sm-4">Beds</dt><dd class="col-sm-8">{{ $roomType->num_beds }} × {{ ucfirst($roomType->bed_type) }}</dd>
                        <dt class="col-sm-4">Base Price</dt><dd class="col-sm-8">${{ number_format($roomType->base_price, 2) }} / night</dd>
                        <dt class="col-sm-4">Size</dt><dd class="col-sm-8">{{ $roomType->size_sqft ?? '—' }} sq ft</dd>
                        <dt class="col-sm-4">Total Rooms</dt><dd class="col-sm-8">{{ $roomType->num_rooms_total }}</dd>
                        <dt class="col-sm-4">Smoking</dt><dd class="col-sm-8">{{ $roomType->is_smoking ? 'Yes' : 'No' }}</dd>
                        <dt class="col-sm-4">Status</dt><dd class="col-sm-8">{!! $roomType->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</dd>
                    </dl>
                </div>
            </div>
            @if ($roomType->description)
                <div class="card mb-3">
                    <div class="card-header">Description</div>
                    <div class="card-body"><p class="mb-0">{{ $roomType->description }}</p></div>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Amenities ({{ $roomType->amenities->count() }})</div>
                <ul class="list-group list-group-flush">
                    @forelse ($roomType->amenities as $amenity)
                        <li class="list-group-item">{{ $amenity->name }}</li>
                    @empty
                        <li class="list-group-item text-muted">No amenities assigned.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card">
                <div class="card-header">Rooms ({{ $roomType->rooms->count() }})</div>
                <ul class="list-group list-group-flush">
                    @forelse ($roomType->rooms as $room)
                        <li class="list-group-item d-flex justify-content-between">
                            Room {{ $room->room_number }}
                            <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'warning' : 'secondary') }}">{{ $room->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No rooms created yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
