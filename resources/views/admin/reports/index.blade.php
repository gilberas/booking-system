<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0"><i class="bi bi-graph-up me-2"></i>Reports</h2>
    </x-slot>

    <div class="row g-3">
        @foreach ([
            ['route' => 'admin.reports.daily-bookings', 'title' => 'Daily Bookings', 'desc' => 'Bookings per day with status breakdown.', 'icon' => 'bi-calendar-day'],
            ['route' => 'admin.reports.monthly-revenue', 'title' => 'Monthly Revenue', 'desc' => 'Revenue and transaction counts by month.', 'icon' => 'bi-currency-dollar'],
            ['route' => 'admin.reports.customers', 'title' => 'Customer Report', 'desc' => 'Customer list with booking counts and spend.', 'icon' => 'bi-people'],
            ['route' => 'admin.reports.occupancy', 'title' => 'Occupancy Report', 'desc' => 'Daily occupancy rates and availability.', 'icon' => 'bi-building'],
            ['route' => 'admin.reports.room-performance', 'title' => 'Room Performance', 'desc' => 'Room booking frequency and performance.', 'icon' => 'bi-door-open'],
            ['route' => 'admin.reports.cancelled-bookings', 'title' => 'Cancelled Bookings', 'desc' => 'Cancelled bookings with reasons and revenue impact.', 'icon' => 'bi-x-circle'],
            ['route' => 'admin.reports.payments', 'title' => 'Payment Report', 'desc' => 'Payments by method, status, and date.', 'icon' => 'bi-credit-card'],
        ] as $report)
            <div class="col-md-4 col-lg-3">
                <a href="{{ route($report['route']) }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 dashboard-card">
                        <div class="icon-circle" style="background:#f8f6f0;color:#c89a3c;"><i class="bi {{ $report['icon'] }}"></i></div>
                        <h6 class="text-dark">{{ $report['title'] }}</h6>
                        <p class="small">{{ $report['desc'] }}</p>
                        <span class="small fw-bold" style="color:#c89a3c;">View Report →</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>
