<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Complete Your Booking') }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('search') }}">Search</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hotels.show', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hotels.room-types.show', [$hotel, $roomType]) }}">{{ $roomType->name }}</a></li>
            <li class="breadcrumb-item active">Book</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Guest Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.book.store') }}">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="check_in" value="{{ $checkIn }}">
                        <input type="hidden" name="check_out" value="{{ $checkOut }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Adults</label>
                                <input type="number" name="adults" class="form-control @error('adults') is-invalid @enderror" value="{{ old('adults', $adults) }}" min="1" max="20">
                                @error('adults')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Children</label>
                                <input type="number" name="children" class="form-control @error('children') is-invalid @enderror" value="{{ old('children', $children) }}" min="0" max="20">
                                @error('children')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Special Requests</label>
                            <textarea name="special_requests" class="form-control @error('special_requests') is-invalid @enderror" rows="3">{{ old('special_requests') }}</textarea>
                            @error('special_requests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('hotels.room-types.show', [$hotel, $roomType]) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-header">Booking Summary</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-6">Hotel</dt><dd class="col-sm-6">{{ $hotel->name }}</dd>
                        <dt class="col-sm-6">Room Type</dt><dd class="col-sm-6">{{ $roomType->name }}</dd>
                        <dt class="col-sm-6">Room</dt><dd class="col-sm-6">#{{ $room->room_number }}</dd>
                        <dt class="col-sm-6">Check-in</dt><dd class="col-sm-6">{{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }}</dd>
                        <dt class="col-sm-6">Check-out</dt><dd class="col-sm-6">{{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}</dd>
                        <dt class="col-sm-6">Nights</dt><dd class="col-sm-6">{{ $numNights }}</dd>
                        <dt class="col-sm-6">Guests</dt><dd class="col-sm-6">{{ (int) $adults + (int) $children }}</dd>
                    </dl>
                    <hr>
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Price / Night</dt><dd class="col-sm-6 text-end">${{ number_format($roomType->base_price, 2) }}</dd>
                        <dt class="col-sm-6">Subtotal</dt><dd class="col-sm-6 text-end">${{ number_format($totalPrice, 2) }}</dd>
                        <dt class="col-sm-6">Tax (10%)</dt><dd class="col-sm-6 text-end">${{ number_format($totalPrice * 0.10, 2) }}</dd>
                        <dt class="col-sm-6 fw-bold">Total</dt><dd class="col-sm-6 text-end fw-bold text-primary">${{ number_format($totalPrice * 1.10, 2) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
