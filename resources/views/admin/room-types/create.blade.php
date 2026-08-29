<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Create Room Type — {{ $hotel->name }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.index', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hotels.room-types.store', $hotel) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Max Occupancy</label>
                        <input type="number" name="max_occupancy" class="form-control @error('max_occupancy') is-invalid @enderror" value="{{ old('max_occupancy', 2) }}" required>
                        @error('max_occupancy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Num Beds</label>
                        <input type="number" name="num_beds" class="form-control @error('num_beds') is-invalid @enderror" value="{{ old('num_beds', 1) }}" required>
                        @error('num_beds')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bed Type</label>
                        <select name="bed_type" class="form-select @error('bed_type') is-invalid @enderror">
                            @foreach (['twin', 'double', 'queen', 'king'] as $type)
                                <option value="{{ $type }}" {{ old('bed_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('bed_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Base Price ($)</label>
                        <input type="number" step="0.01" name="base_price" class="form-control @error('base_price') is-invalid @enderror" value="{{ old('base_price') }}" required>
                        @error('base_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Size (sq ft)</label>
                        <input type="number" name="size_sqft" class="form-control" value="{{ old('size_sqft') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Rooms of This Type</label>
                        <input type="number" name="num_rooms_total" class="form-control @error('num_rooms_total') is-invalid @enderror" value="{{ old('num_rooms_total', 5) }}" required>
                        @error('num_rooms_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="hidden" name="is_smoking" value="0">
                            <input type="checkbox" name="is_smoking" class="form-check-input" value="1" id="is_smoking" {{ old('is_smoking') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_smoking">Smoking Allowed</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.hotels.room-types.index', $hotel) }}" class="btn btn-outline-navy">Cancel</a>
                    <button type="submit" class="btn btn-navy">Create Room Type</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
