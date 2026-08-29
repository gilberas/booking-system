<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Search Available Rooms') }}</h2>
    </x-slot>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('search') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Hotel</label>
                        <select name="hotel_id" class="form-select">
                            <option value="">All Hotels</option>
                            @foreach ($hotels as $h)
                                <option value="{{ $h->id }}" {{ request('hotel_id') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Check-in</label>
                        <input type="date" name="check_in" class="form-control @error('check_in') is-invalid @enderror" value="{{ old('check_in', request('check_in')) }}" required>
                        @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Check-out</label>
                        <input type="date" name="check_out" class="form-control @error('check_out') is-invalid @enderror" value="{{ old('check_out', request('check_out')) }}" required>
                        @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Guests</label>
                        <input type="number" name="guests" class="form-control @error('guests') is-invalid @enderror" value="{{ old('guests', request('guests', 1)) }}" min="1" required>
                        @error('guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>

                @if(request()->has('check_in'))
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Min Price</label>
                            <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Max Price</label>
                            <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amenities</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($amenities as $amenity)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="amenities[]" class="form-check-input" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" {{ in_array($amenity->id, (array) request('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity_{{ $amenity->id }}">{{ $amenity->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if ($results !== null)
        <h4 class="mb-3">
            Available Rooms at {{ $selectedHotel?->name ?? 'Hotel' }}
        </h4>

        @if ($results->isEmpty())
            <div class="alert alert-info">No rooms match your criteria. Try different dates or filters.</div>
        @else
            <div class="row">
                @foreach ($results as $roomType)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $roomType->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $roomType->num_beds }} × {{ ucfirst($roomType->bed_type) }} · Up to {{ $roomType->max_occupancy }} guests
                                </h6>
                                <p class="card-text">{{ Str::limit($roomType->description, 120) }}</p>
                                <div class="mb-2">
                                    @foreach ($roomType->amenities as $amenity)
                                        <span class="badge bg-light text-dark me-1">{{ $amenity->name }}</span>
                                    @endforeach
                                </div>
                                <p class="h5 text-primary mb-2">${{ number_format($roomType->base_price, 2) }}/night</p>
                                <p class="text-success small">{{ $roomType->available_rooms_count }} room(s) available</p>
                                <a href="{{ route('hotels.room-types.show', [$selectedHotel, $roomType]) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <p class="text-muted">Use the search form above to find available rooms.</p>
        </div>
    @endif
</x-app-layout>
