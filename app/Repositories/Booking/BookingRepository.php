<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookingRepository
{
    public function paginateByUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Booking::with(['hotel', 'bookingRooms.room', 'bookingRooms.roomType'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Booking
    {
        return Booking::with(['hotel', 'bookingRooms.room', 'bookingRooms.roomType', 'user', 'review'])->find($id);
    }

    public function findByBookingNumber(string $bookingNumber): ?Booking
    {
        return Booking::with(['hotel', 'bookingRooms.room', 'bookingRooms.roomType', 'user', 'review'])
            ->where('booking_number', $bookingNumber)
            ->first();
    }

    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(Booking $booking, array $data): bool
    {
        return $booking->update($data);
    }

    public function addRoom(Booking $booking, array $data): BookingRoom
    {
        return $booking->bookingRooms()->create($data);
    }

    public function getConflictingBookingRooms(int $roomId, string $checkIn, string $checkOut, ?int $excludeBookingId = null): Collection
    {
        $query = BookingRoom::where('room_id', $roomId)
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->whereHas('booking', fn ($q) => $q->whereNotIn('status', ['cancelled', 'expired']));

        if ($excludeBookingId) {
            $query->where('booking_id', '!=', $excludeBookingId);
        }

        return $query->get();
    }

    public function getAvailableRooms(int $hotelId, string $checkIn, string $checkOut): Collection
    {
        return Room::where('hotel_id', $hotelId)
            ->where('status', 'available')
            ->whereDoesntHave('bookingRooms', function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn)
                    ->whereHas('booking', fn ($b) => $b->whereNotIn('status', ['cancelled', 'expired']));
            })
            ->with('roomType')
            ->get();
    }

    public function lockRoomForUpdate(int $roomId): Room
    {
        return Room::where('id', $roomId)->lockForUpdate()->firstOrFail();
    }
}
