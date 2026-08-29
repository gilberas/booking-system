<?php

namespace App\Services\Hotel;

use App\Models\Amenity;
use App\Repositories\Hotel\AmenityRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AmenityService
{
    public function __construct(
        private readonly AmenityRepository $repository
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findById(int $id): ?Amenity
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): Amenity
    {
        $data['slug'] = Str::slug($data['name']);

        return $this->repository->create($data);
    }

    public function update(Amenity $amenity, array $data): bool
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->repository->update($amenity, $data);
    }

    public function delete(Amenity $amenity): bool
    {
        return $this->repository->delete($amenity);
    }
}
