<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Edit Amenity — {{ $amenity->name }}</h2>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.amenities.index') }}">Amenities</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.amenities.update', $amenity) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $amenity->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @foreach (['room', 'hotel', 'general'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $amenity->category) == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Icon (optional)</label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon', $amenity->icon) }}" placeholder="e.g. bi-wifi">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $amenity->description) }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-navy">Cancel</a>
                    <button type="submit" class="btn btn-navy">Update Amenity</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
