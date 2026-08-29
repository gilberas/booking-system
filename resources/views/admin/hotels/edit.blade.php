<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Edit Hotel') }}: {{ $hotel->name }}</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hotels.update', $hotel) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $hotel->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $hotel->city) }}" required>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $hotel->country) }}" required>
                        @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Star Rating</label>
                        <select name="star_rating" class="form-select @error('star_rating') is-invalid @enderror">
                            @for ($i = 1; $i <= 5; $i++)<option value="{{ $i }}" {{ old('star_rating', $hotel->star_rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>@endfor
                        </select>
                        @error('star_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $hotel->state) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $hotel->postal_code) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $hotel->address) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $hotel->phone) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $hotel->email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website', $hotel->website) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Check-in Time</label>
                        <input type="time" name="check_in_time" class="form-control" value="{{ old('check_in_time', $hotel->check_in_time) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Check-out Time</label>
                        <input type="time" name="check_out_time" class="form-control" value="{{ old('check_out_time', $hotel->check_out_time) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $hotel->description) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', $hotel->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-navy">Cancel</a>
                    <button type="submit" class="btn btn-navy">Update Hotel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
