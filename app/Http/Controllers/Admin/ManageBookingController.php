<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ManageBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'hotel']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('booking_number', 'like', "%{$s}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$s}%"))
                    ->orWhereHas('hotel', fn ($h) => $h->where('name', 'like', "%{$s}%"));
            });
        }

        $bookings = $query->latest()->paginate(20);

        return view('admin.manage-bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'hotel', 'bookingRooms.room', 'bookingRooms.roomType', 'payments', 'invoice', 'review']);

        return view('admin.manage-bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,checked_in,checked_out,cancelled,expired'],
        ]);

        $booking->update(['status' => $validated['status']]);
        $booking->bookingRooms()->update(['status' => $validated['status']]);

        return redirect()->route('admin.manage-bookings.show', $booking)
            ->with('success', "Booking status updated to {$validated['status']}.");
    }
}
