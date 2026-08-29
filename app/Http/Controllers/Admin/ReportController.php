<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use App\Services\Admin\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService,
        private readonly DashboardService $dashboardService,
    ) {}

    public function index()
    {
        return view('admin.reports.index');
    }

    public function dailyBookings(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->dailyBookings($from, $to);

        return view('admin.reports.daily-bookings', $data);
    }

    public function monthlyRevenue(Request $request)
    {
        $from = $request->input('from', now()->startOfYear()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->monthlyRevenue($from, $to);

        return view('admin.reports.monthly-revenue', $data);
    }

    public function customers(Request $request)
    {
        $from = $request->input('from', now()->startOfYear()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->customers($from, $to);

        return view('admin.reports.customers', $data);
    }

    public function occupancy(Request $request)
    {
        $from = $request->input('from', now()->subDays(30)->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->occupancy($from, $to);

        return view('admin.reports.occupancy', $data);
    }

    public function roomPerformance(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->roomPerformance($from, $to);

        return view('admin.reports.room-performance', $data);
    }

    public function cancelledBookings(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->cancelledBookings($from, $to);

        return view('admin.reports.cancelled-bookings', $data);
    }

    public function payments(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $data = $this->reportService->payments($from, $to);

        return view('admin.reports.payments', $data);
    }
}
