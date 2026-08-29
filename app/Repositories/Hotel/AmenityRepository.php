<?php

namespace App\Repositories\Hotel;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AmenityRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Amenity::orderBy('name')->paginate($perPage);
    }

    public function findById(int $id): ?Amenity
    {
        return Amenity::find($id);
    }

    public function create(array $data): Amenity
    {
        return Amenity::create($data);
    }

    public function update(Amenity $amenity, array $data): bool
    {
        return $amenity->update($data);
    }

    public function delete(Amenity $amenity): bool
    {
        return $amenity->delete();
    }

    public function all(): Collection
    {
        return Amenity::orderBy('name')->get();
    }
}
