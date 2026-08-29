<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $hotel->name }}</h2>
            <div>
                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-sm btn-outline-navy">Edit</a>
                <a href="{{ route('admin.hotels.room-types.index', $hotel) }}" class="btn btn-sm btn-outline-navy">Room Types</a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">City</dt><dd class="col-sm-9">{{ $hotel->city }}, {{ $hotel->country }}</dd>
                        <dt class="col-sm-3">Address</dt><dd class="col-sm-9">{{ $hotel->address ?? '—' }}</dd>
                        <dt class="col-sm-3">Rating</dt><dd class="col-sm-9">{{ str_repeat('★', $hotel->star_rating) }}</dd>
                        <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $hotel->phone ?? '—' }}</dd>
                        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $hotel->email ?? '—' }}</dd>
                        <dt class="col-sm-3">Check-in</dt><dd class="col-sm-9">{{ $hotel->check_in_time }}</dd>
                        <dt class="col-sm-3">Check-out</dt><dd class="col-sm-9">{{ $hotel->check_out_time }}</dd>
                        <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{!! $hotel->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</dd>
                    </dl>
                </div>
            </div>
            @if ($hotel->description)
                <div class="card mb-3">
                    <div class="card-header">Description</div>
                    <div class="card-body"><p class="mb-0">{{ $hotel->description }}</p></div>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Room Types ({{ $hotel->roomTypes->count() }})</div>
                <ul class="list-group list-group-flush">
                    @forelse ($hotel->roomTypes as $rt)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $rt->name }}
                            <a href="{{ route('admin.hotels.room-types.show', [$hotel, $rt]) }}" class="btn btn-sm btn-outline-navy">View</a>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No room types yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
