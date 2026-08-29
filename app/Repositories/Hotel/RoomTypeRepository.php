<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomTypeRepository
{
    public function paginateByHotel(Hotel $hotel, int $perPage = 15): LengthAwarePaginator
    {
        return $hotel->roomTypes()->orderBy('name')->paginate($perPage);
    }

    public function findById(int $id): ?RoomType
    {
        return RoomType::with('hotel')->find($id);
    }

    public function create(Hotel $hotel, array $data): RoomType
    {
        return $hotel->roomTypes()->create($data);
    }

    public function update(RoomType $roomType, array $data): bool
    {
        return $roomType->update($data);
    }

    public function delete(RoomType $roomType): bool
    {
        return $roomType->delete();
    }
}
