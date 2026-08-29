<?php

namespace App\Repositories\Hotel;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomRepository
{
    public function paginateByRoomType(RoomType $roomType, int $perPage = 30): LengthAwarePaginator
    {
        return $roomType->rooms()->orderBy('room_number')->paginate($perPage);
    }

    public function findById(int $id): ?Room
    {
        return Room::with(['roomType', 'hotel'])->find($id);
    }

    public function create(RoomType $roomType, array $data): Room
    {
        return $roomType->rooms()->create($data);
    }

    public function update(Room $room, array $data): bool
    {
        return $room->update($data);
    }

    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    public function getAvailable(int $roomTypeId, string $checkIn, string $checkOut): Collection
    {
        return Room::where('room_type_id', $roomTypeId)
            ->where('status', 'available')
            ->whereDoesntHave('bookingRooms', function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn)
                    ->whereIn('status', ['pending', 'confirmed', 'checked_in']);
            })
            ->get();
    }
}
