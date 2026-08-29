<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Models\RoomType;
use App\Repositories\Hotel\RoomTypeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class RoomTypeService
{
    public function __construct(
        private readonly RoomTypeRepository $repository
    ) {}

    public function paginateByHotel(Hotel $hotel, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateByHotel($hotel, $perPage);
    }

    public function findById(int $id): ?RoomType
    {
        return $this->repository->findById($id);
    }

    public function create(Hotel $hotel, array $data): RoomType
    {
        $data['slug'] = Str::slug($data['name'].'-'.$hotel->slug);

        return $this->repository->create($hotel, $data);
    }

    public function update(RoomType $roomType, array $data): bool
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name'].'-'.$roomType->hotel->slug);
        }

        return $this->repository->update($roomType, $data);
    }

    public function delete(RoomType $roomType): bool
    {
        return $this->repository->delete($roomType);
    }
}
