<?php

namespace App\Services\Admin;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;

class DashboardService
{
    public function getStats(): array
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $today = now()->format('Y-m-d');
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $todayCheckIns = Booking::whereDate('check_in', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])->count();
        $todayCheckOuts = Booking::whereDate('check_out', $today)
            ->whereIn('status', ['checked_in', 'checked_out'])->count();

        $monthStart = now()->startOfMonth();
        $monthlyRevenue = Payment::where('status', 'paid')
            ->where('paid_at', '>=', $monthStart)
            ->sum('amount');

        $yearStart = now()->startOfYear();
        $annualRevenue = Payment::where('status', 'paid')
            ->where('paid_at', '>=', $yearStart)
            ->sum('amount');

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        $recentCustomers = User::whereHas('roles', fn ($q) => $q->where('slug', 'registered-customer'))
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'hotel'])
            ->latest()
            ->take(5)
            ->get();

        return compact(
            'totalRooms', 'availableRooms', 'occupiedRooms', 'maintenanceRooms',
            'todayBookings', 'todayCheckIns', 'todayCheckOuts',
            'monthlyRevenue', 'annualRevenue', 'totalRevenue',
            'recentCustomers', 'recentBookings',
        );
    }

    public function getRevenueChartData(int $months = 12): array
    {
        $labels = [];
        $data = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $revenue = Payment::where('status', 'paid')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');

            $data[] = (float) $revenue;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    public function getOccupancyChartData(int $days = 30): array
    {
        $labels = [];
        $occupied = [];
        $available = [];

        $totalRooms = max(1, Room::count());

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M d');

            $occupiedCount = Booking::where('check_in', '<=', $date->format('Y-m-d'))
                ->where('check_out', '>', $date->format('Y-m-d'))
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->count();

            $occupied[] = $occupiedCount;
            $available[] = max(0, $totalRooms - $occupiedCount);
        }

        return ['labels' => $labels, 'occupied' => $occupied, 'available' => $available];
    }

    public function getBookingStatusCounts(): array
    {
        return [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'checked_in' => Booking::where('status', 'checked_in')->count(),
            'checked_out' => Booking::where('status', 'checked_out')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'expired' => Booking::where('status', 'expired')->count(),
        ];
    }
}
