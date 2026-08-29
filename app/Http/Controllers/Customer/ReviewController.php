<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Booking;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 404);

        if ($booking->status !== 'checked_out') {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('error', 'You can only review a booking after checkout.');
        }

        if ($booking->review()->exists()) {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('info', 'You have already reviewed this booking.');
        }

        return view('customer.reviews.create', compact('booking'));
    }

    public function store(StoreReviewRequest $request, Booking $booking)
    {
        $booking->review()->create([
            'user_id' => auth()->id(),
            'hotel_id' => $booking->hotel_id,
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Thank you! Your review has been submitted.');
    }
}
