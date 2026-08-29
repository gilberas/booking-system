<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ $roomType->name }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('search') }}">Search</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hotels.show', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item active">{{ $roomType->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Max Occupancy</dt><dd class="col-sm-8">{{ $roomType->max_occupancy }} guests</dd>
                        <dt class="col-sm-4">Beds</dt><dd class="col-sm-8">{{ $roomType->num_beds }} × {{ ucfirst($roomType->bed_type) }}</dd>
                        <dt class="col-sm-4">Price</dt><dd class="col-sm-8"><strong class="text-primary">${{ number_format($roomType->base_price, 2) }}</strong> / night</dd>
                        <dt class="col-sm-4">Size</dt><dd class="col-sm-8">{{ $roomType->size_sqft ?? '—' }} sq ft</dd>
                        <dt class="col-sm-4">Smoking</dt><dd class="col-sm-8">{{ $roomType->is_smoking ? 'Allowed' : 'Not allowed' }}</dd>
                    </dl>
                </div>
            </div>

            @if ($roomType->description)
                <div class="card mb-3">
                    <div class="card-header">Description</div>
                    <div class="card-body"><p class="mb-0">{{ $roomType->description }}</p></div>
                </div>
            @endif

            @if ($roomType->amenities->isNotEmpty())
                <div class="card mb-3">
                    <div class="card-header">Amenities</div>
                    <div class="card-body">
                        @foreach ($roomType->amenities as $amenity)
                            <span class="badge bg-light text-dark me-2 mb-2">{{ $amenity->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Book This Room</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('customer.book.create') }}">
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                        <div class="mb-3">
                            <label class="form-label">Check-in</label>
                            <input type="date" name="check_in" class="form-control" value="{{ request('check_in', now()->addDay()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Check-out</label>
                            <input type="date" name="check_out" class="form-control" value="{{ request('check_out', now()->addDays(2)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adults</label>
                            <input type="number" name="adults" class="form-control" value="{{ request('adults', 1) }}" min="1" max="{{ $roomType->max_occupancy }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Children</label>
                            <input type="number" name="children" class="form-control" value="{{ request('children', 0) }}" min="0" max="10">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Check Availability & Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
