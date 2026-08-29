<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Create Room — {{ $roomType->name }} ({{ $hotel->name }})</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.index', $hotel) }}">{{ $hotel->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.show', [$hotel, $roomType]) }}">{{ $roomType->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hotels.room-types.rooms.index', [$hotel, $roomType]) }}">Rooms</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hotels.room-types.rooms.store', [$hotel, $roomType]) }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Room Number</label>
                        <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}" required>
                        @error('room_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Floor</label>
                        <input type="number" name="floor" class="form-control @error('floor') is-invalid @enderror" value="{{ old('floor', 1) }}" required>
                        @error('floor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach (['available', 'occupied', 'maintenance', 'reserved'] as $s)
                                <option value="{{ $s }}" {{ old('status', 'available') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.hotels.room-types.rooms.index', [$hotel, $roomType]) }}" class="btn btn-outline-navy">Cancel</a>
                    <button type="submit" class="btn btn-navy">Create Room</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
