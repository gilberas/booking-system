<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $isManager = $user->hasRole('hotel-manager');

        $todayCheckIns = Booking::whereDate('check_in', today())->where('status', 'confirmed')->count();
        $todayCheckOuts = Booking::whereDate('check_out', today())->whereIn('status', ['confirmed', 'checked_in'])->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $todayBookings = Booking::whereDate('created_at', today())->count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalRooms = Room::count();

        $data = compact(
            'isManager', 'todayCheckIns', 'todayCheckOuts', 'pendingBookings',
            'todayBookings', 'availableRooms', 'totalRooms'
        );

        if ($isManager) {
            $data['monthlyRevenue'] = Payment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount');
            $data['occupancyRate'] = $totalRooms > 0
                ? round(($totalRooms - $availableRooms) / $totalRooms * 100)
                : 0;
            $data['totalBookings'] = Booking::count();
            $data['recentBookings'] = Booking::with(['user', 'hotel'])->latest()->take(5)->get();
        }

        return view('staff.dashboard', $data);
    }
}
