<?php

namespace App\Services\Hotel;

use App\Models\Room;
use App\Models\RoomType;
use App\Repositories\Hotel\RoomRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    public function __construct(
        private readonly RoomRepository $repository
    ) {}

    public function paginateByRoomType(RoomType $roomType, int $perPage = 30): LengthAwarePaginator
    {
        return $this->repository->paginateByRoomType($roomType, $perPage);
    }

    public function findById(int $id): ?Room
    {
        return $this->repository->findById($id);
    }

    public function create(RoomType $roomType, array $data): Room
    {
        $data['hotel_id'] = $roomType->hotel_id;

        return $this->repository->create($roomType, $data);
    }

    public function update(Room $room, array $data): bool
    {
        return $this->repository->update($room, $data);
    }

    public function delete(Room $room): bool
    {
        return $this->repository->delete($room);
    }
}
