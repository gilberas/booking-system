<?php

namespace App\Services\Admin;

use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Carbon;

class ReportService
{
    public function dailyBookings(string $from, string $to): array
    {
        $records = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $total = $records->sum('total');
        $avgPerDay = $records->avg('total');

        return compact('records', 'total', 'avgPerDay', 'from', 'to');
    }

    public function monthlyRevenue(string $from, string $to): array
    {
        $payments = Payment::where('status', 'paid')
            ->whereDate('paid_at', '>=', $from)
            ->whereDate('paid_at', '<=', $to)
            ->get(['paid_at', 'amount']);

        $grouped = $payments->groupBy(fn ($p) => Carbon::parse($p->paid_at)->format('Y-m'));

        $records = collect();
        foreach ($grouped as $ym => $group) {
            $dt = Carbon::createFromFormat('Y-m', $ym);
            $records->push([
                'month' => $dt->format('M Y'),
                'revenue' => (float) $group->sum('amount'),
                'transactions' => $group->count(),
            ]);
        }

        $records = $records->sortBy(fn ($r) => Carbon::createFromFormat('M Y', $r['month'])->format('Y-m'))->values();

        $total = $records->sum('revenue');
        $avgPerMonth = $records->avg('revenue');

        return compact('records', 'total', 'avgPerMonth', 'from', 'to');
    }

    public function customers(string $from, string $to): array
    {
        $records = User::whereHas('roles', fn ($q) => $q->where('slug', 'registered-customer'))
            ->withCount(['bookings', 'reviews'])
            ->withSum('bookings', 'total_amount')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->orderByDesc('bookings_count')
            ->get();

        $total = $records->count();
        $active = $records->filter(fn ($u) => $u->bookings_count > 0)->count();

        return compact('records', 'total', 'active', 'from', 'to');
    }

    public function occupancy(string $from, string $to): array
    {
        $totalRooms = max(1, Room::count());

        $bookingRooms = BookingRoom::with('booking')
            ->whereHas('booking', fn ($q) => $q->whereIn('status', ['confirmed', 'checked_in']))
            ->whereDate('check_in', '<=', $to)
            ->whereDate('check_out', '>', $from)
            ->get();

        $records = collect();
        $period = Carbon::parse($from);
        $end = Carbon::parse($to);

        while ($period->lte($end)) {
            $date = $period->format('Y-m-d');

            $occupied = $bookingRooms->filter(fn ($br) => $br->check_in->lte($date) && $br->check_out->gt($date))->count();

            $records->push([
                'date' => $date,
                'occupied' => $occupied,
                'available' => max(0, $totalRooms - $occupied),
                'rate' => $totalRooms > 0 ? round(($occupied / $totalRooms) * 100, 1) : 0,
            ]);

            $period->addDay();
        }

        $avgRate = $records->avg('rate');

        return compact('records', 'totalRooms', 'avgRate', 'from', 'to');
    }

    public function roomPerformance(string $from, string $to): array
    {
        $records = Room::with(['roomType', 'hotel'])
            ->withCount(['bookingRooms' => fn ($q) => $q->whereHas('booking', fn ($b) => $b->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to))])
            ->orderByDesc('bookingRooms_count')
            ->get();

        return compact('records', 'from', 'to');
    }

    public function cancelledBookings(string $from, string $to): array
    {
        $records = Booking::with(['user', 'hotel'])
            ->where('status', 'cancelled')
            ->whereDate('cancelled_at', '>=', $from)
            ->whereDate('cancelled_at', '<=', $to)
            ->orderByDesc('cancelled_at')
            ->get();

        $total = $records->count();
        $totalRevenue = $records->sum('total_amount');

        return compact('records', 'total', 'totalRevenue', 'from', 'to');
    }

    public function payments(string $from, string $to): array
    {
        $records = Payment::with(['booking', 'user'])
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->orderByDesc('created_at')
            ->get();

        $total = $records->sum('amount');
        $byMethod = $records->groupBy('payment_method')->map(fn ($g) => $g->sum('amount'));
        $byStatus = $records->groupBy('status')->map(fn ($g) => $g->sum('amount'));

        return compact('records', 'total', 'byMethod', 'byStatus', 'from', 'to');
    }
}
