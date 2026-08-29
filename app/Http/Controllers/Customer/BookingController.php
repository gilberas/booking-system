<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CancelBookingRequest;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Booking\BookingService;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService
    ) {}

    public function index()
    {
        $bookings = $this->bookingService->getUserBookings(auth()->id());

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $hotelId = request('hotel_id');
        $roomTypeId = request('room_type_id');
        $roomId = request('room_id');
        $checkIn = request('check_in');
        $checkOut = request('check_out');
        $adults = request('adults', 1);
        $children = request('children', 0);

        abort_if(! $hotelId || ! $roomTypeId || ! $roomId || ! $checkIn || ! $checkOut, 404);

        $hotel = Hotel::findOrFail($hotelId);
        $roomType = RoomType::findOrFail($roomTypeId);
        $room = Room::findOrFail($roomId);

        $numNights = max(1, (int) date_create($checkOut)->diff(date_create($checkIn))->days);
        $totalPrice = $roomType->base_price * $numNights;

        return view('customer.bookings.create', compact(
            'hotel', 'roomType', 'room', 'checkIn', 'checkOut',
            'adults', 'children', 'numNights', 'totalPrice'
        ));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking(
            userId: auth()->id(),
            hotelId: (int) $request->input('hotel_id'),
            roomTypeId: (int) $request->input('room_type_id'),
            roomId: (int) $request->input('room_id'),
            checkIn: $request->input('check_in'),
            checkOut: $request->input('check_out'),
            adults: (int) $request->input('adults', 1),
            children: (int) $request->input('children', 0),
            pricePerNight: (float) RoomType::findOrFail($request->input('room_type_id'))->base_price,
            specialRequests: $request->input('special_requests'),
        );

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Booking created successfully! Your booking number is '.$booking->booking_number);
    }

    public function show(int $id)
    {
        $booking = $this->bookingService->findBooking($id);

        abort_if(! $booking || $booking->user_id !== auth()->id(), 404);

        try {
            $this->bookingService->assertCanCancel($booking);
            $canCancel = true;
        } catch (\RuntimeException) {
            $canCancel = false;
        }

        return view('customer.bookings.show', compact('booking', 'canCancel'));
    }

    public function cancel(int $id, CancelBookingRequest $request)
    {
        $booking = $this->bookingService->findBooking($id);
        abort_if(! $booking || $booking->user_id !== auth()->id(), 404);

        $booking = $this->bookingService->cancelBooking($booking, $request->input('cancellation_reason'));

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', sprintf(
                'Booking cancelled. Refund: %d%% ($%s).',
                $booking->refund_percentage,
                number_format($booking->refund_amount, 2)
            ));
    }
}
