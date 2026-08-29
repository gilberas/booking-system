<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $userId = Auth::id();

        $upcoming = Booking::with('hotel')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '>=', now())
            ->orderBy('check_in')
            ->take(5)
            ->get();

        $past = Booking::with('hotel')
            ->where('user_id', $userId)
            ->whereIn('status', ['checked_out', 'cancelled', 'expired'])
            ->orderByDesc('check_out')
            ->take(5)
            ->get();

        $active = Booking::with('hotel')
            ->where('user_id', $userId)
            ->where('status', 'checked_in')
            ->orderBy('check_out')
            ->take(5)
            ->get();

        $totalBookings = Booking::where('user_id', $userId)->count();
        $upcomingCount = Booking::where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '>=', now())
            ->count();
        $completedCount = Booking::where('user_id', $userId)
            ->where('status', 'checked_out')
            ->count();

        return view('customer.dashboard', compact(
            'upcoming', 'past', 'active', 'totalBookings', 'upcomingCount', 'completedCount'
        ));
    }
}
