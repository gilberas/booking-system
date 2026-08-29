<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ $hotel->name }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('search') }}">Search</a></li>
            <li class="breadcrumb-item active">{{ $hotel->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">About</div>
                <div class="card-body">
                    <p>{{ $hotel->description ?? 'No description available.' }}</p>
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Address</dt><dd class="col-sm-9">{{ $hotel->address ?? '—' }}, {{ $hotel->city }}, {{ $hotel->country }}</dd>
                        <dt class="col-sm-3">Rating</dt><dd class="col-sm-9">{{ str_repeat('★', $hotel->star_rating) }}{{ str_repeat('☆', 5 - $hotel->star_rating) }}</dd>
                        <dt class="col-sm-3">Check-in</dt><dd class="col-sm-9">{{ substr($hotel->check_in_time, 0, 5) }}</dd>
                        <dt class="col-sm-3">Check-out</dt><dd class="col-sm-9">{{ substr($hotel->check_out_time, 0, 5) }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Room Types ({{ $hotel->roomTypes->count() }})</div>
                <div class="list-group list-group-flush">
                    @forelse ($hotel->roomTypes as $rt)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $rt->name }}</h6>
                                    <small class="text-muted">{{ $rt->num_beds }} × {{ ucfirst($rt->bed_type) }} · {{ $rt->max_occupancy }} guests · {{ $rt->num_rooms_total }} rooms</small>
                                    <div class="mt-1">
                                        @foreach ($rt->amenities as $amenity)
                                            <span class="badge bg-light text-dark me-1">{{ $amenity->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-1">${{ number_format($rt->base_price, 2) }}</div>
                                    <small class="text-muted">per night</small>
                                    <div class="mt-1">
                                        <a href="{{ route('hotels.room-types.show', [$hotel, $rt]) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-muted">No room types available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
