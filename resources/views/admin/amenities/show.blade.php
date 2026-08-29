<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $amenity->name }}</h2>
            <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-sm btn-outline-navy">Edit</a>
        </div>
    </x-slot>

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.amenities.index') }}">Amenities</a></li>
            <li class="breadcrumb-item active">{{ $amenity->name }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $amenity->name }}</dd>
                <dt class="col-sm-3">Category</dt><dd class="col-sm-9"><span class="badge bg-info">{{ ucfirst($amenity->category) }}</span></dd>
                <dt class="col-sm-3">Icon</dt><dd class="col-sm-9">{{ $amenity->icon ?? '—' }}</dd>
                @if ($amenity->description)
                    <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $amenity->description }}</dd>
                @endif
            </dl>
        </div>
    </div>
</x-app-layout>
