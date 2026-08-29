<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function __invoke()
    {
        $stats = $this->dashboardService->getStats();
        $revenueChart = $this->dashboardService->getRevenueChartData();
        $occupancyChart = $this->dashboardService->getOccupancyChartData();
        $bookingStatuses = $this->dashboardService->getBookingStatusCounts();

        return view('admin.dashboard', compact(
            'stats', 'revenueChart', 'occupancyChart', 'bookingStatuses'
        ));
    }
}
