<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Repositories\Hotel\HotelRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class HotelService
{
    public function __construct(
        private readonly HotelRepository $repository
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findById(int $id): ?Hotel
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): Hotel
    {
        $data['slug'] = Str::slug($data['name']);

        return $this->repository->create($data);
    }

    public function update(Hotel $hotel, array $data): bool
    {
        if (isset($data['name']) && $data['name'] !== $hotel->name) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->repository->update($hotel, $data);
    }

    public function delete(Hotel $hotel): bool
    {
        return $this->repository->delete($hotel);
    }
}
