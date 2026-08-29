<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\Room;
use App\Notifications\BookingCancelled;
use App\Notifications\BookingConfirmed;
use App\Repositories\Booking\BookingRepository;
use App\Services\Audit\AuditLogService;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    private const CANCELLATION_FREE_HOURS = 48;

    private const CANCELLATION_LATE_PERCENT = 50;

    public function __construct(
        private readonly BookingRepository $repository,
        private readonly DatabaseManager $db,
        private readonly AuditLogService $auditLog,
    ) {}

    public function getAvailableRoomTypes(int $hotelId, string $checkIn, string $checkOut, int $guests): Collection
    {
        $availableRooms = $this->repository->getAvailableRooms($hotelId, $checkIn, $checkOut);

        return $availableRooms
            ->filter(fn (Room $room) => $room->roomType && $room->roomType->max_occupancy >= $guests)
            ->groupBy('room_type_id')
            ->map(function (Collection $rooms, int $roomTypeId) {
                $roomType = $rooms->first()->roomType;
                $roomType->available_rooms_count = $rooms->count();
                $roomType->available_rooms = $rooms;

                return $roomType;
            })
            ->values();
    }

    public function checkRoomAvailability(int $roomId, string $checkIn, string $checkOut, ?int $excludeBookingId = null): bool
    {
        return $this->repository->getConflictingBookingRooms($roomId, $checkIn, $checkOut, $excludeBookingId)->isEmpty();
    }

    public function createBooking(
        int $userId,
        int $hotelId,
        int $roomTypeId,
        int $roomId,
        string $checkIn,
        string $checkOut,
        int $adults,
        int $children,
        float $pricePerNight,
        ?string $specialRequests = null,
    ): Booking {
        return DB::transaction(function () use (
            $userId, $hotelId, $roomTypeId, $roomId,
            $checkIn, $checkOut, $adults, $children,
            $pricePerNight, $specialRequests
        ) {
            $this->repository->lockRoomForUpdate($roomId);

            if (! $this->checkRoomAvailability($roomId, $checkIn, $checkOut)) {
                throw new \RuntimeException('This room is no longer available for the selected dates.');
            }

            $numNights = max(1, (int) date_create($checkOut)->diff(date_create($checkIn))->days);
            $totalPrice = $pricePerNight * $numNights;
            $numGuests = $adults + $children;

            $booking = $this->repository->create([
                'booking_number' => $this->generateBookingNumber(),
                'user_id' => $userId,
                'hotel_id' => $hotelId,
                'status' => 'pending',
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'num_guests' => $numGuests,
                'adults' => $adults,
                'children' => $children,
                'subtotal' => $totalPrice,
                'tax_amount' => round($totalPrice * 0.10, 2),
                'total_amount' => round($totalPrice * 1.10, 2),
                'paid_amount' => 0,
                'currency' => 'USD',
                'booking_source' => 'web',
                'special_requests' => $specialRequests,
            ]);

            $this->repository->addRoom($booking, [
                'room_id' => $roomId,
                'room_type_id' => $roomTypeId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'adults' => $adults,
                'children' => $children,
                'price_per_night' => $pricePerNight,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            $booking->load('user');

            $booking->user->notify(new BookingConfirmed($booking));

            $this->auditLog->log('booking_created', $booking, [
                'room_id' => $roomId,
                'room_type_id' => $roomTypeId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'total_amount' => $booking->total_amount,
            ]);

            return $booking->fresh(['hotel', 'bookingRooms.room', 'bookingRooms.roomType']);
        });
    }

    public function cancelBooking(Booking $booking, string $reason): Booking
    {
        $this->assertCanCancel($booking);

        $now = now();
        $checkIn = Carbon::parse($booking->check_in);
        $hoursUntilCheckIn = $now->diffInHours($checkIn, false);

        $refundPercentage = match (true) {
            $hoursUntilCheckIn >= self::CANCELLATION_FREE_HOURS => 100,
            $hoursUntilCheckIn >= 0 => 100 - self::CANCELLATION_LATE_PERCENT,
            default => 0,
        };

        DB::transaction(function () use ($booking, $reason, $refundPercentage) {
            $oldStatus = $booking->status;

            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => $reason,
                'cancelled_at' => now(),
            ]);

            $booking->bookingRooms()->update(['status' => 'cancelled']);

            $this->auditLog->log('booking_cancelled', $booking, [
                'old_status' => $oldStatus,
                'new_status' => 'cancelled',
                'reason' => $reason,
                'refund_percentage' => $refundPercentage,
            ]);
        });

        $booking->refund_percentage = $refundPercentage;
        $booking->refund_amount = round($booking->total_amount * $refundPercentage / 100, 2);

        $booking->load('user');

        $booking->user->notify(new BookingCancelled($booking));

        return $booking->fresh(['hotel', 'bookingRooms.room', 'bookingRooms.roomType']);
    }

    public function assertCanCancel(Booking $booking): void
    {
        if (! in_array($booking->status, ['pending', 'confirmed'])) {
            throw new \RuntimeException(
                "Booking cannot be cancelled in its current state ('{$booking->status}'). Only pending or confirmed bookings can be cancelled."
            );
        }

        if (now()->greaterThanOrEqualTo($booking->check_out)) {
            throw new \RuntimeException('Cannot cancel a booking after the checkout date has passed.');
        }
    }

    public function getUserBookings(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateByUser($userId, $perPage);
    }

    public function findBooking(int $id): ?Booking
    {
        return $this->repository->findById($id);
    }

    private function generateBookingNumber(): string
    {
        $prefix = 'BK';
        $timestamp = now()->format('ymdHis');
        $random = strtoupper(Str::random(4));

        return "{$prefix}-{$timestamp}-{$random}";
    }
}
