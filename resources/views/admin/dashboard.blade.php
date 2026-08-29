<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-shield-lock me-2"></i>Admin Dashboard</h2>
            <span class="badge px-3 py-2" style="background:#c89a3c;color:#1a2332;">{{ now()->format('l, F d, Y') }}</span>
        </div>
    </x-slot>

    {{-- Room Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm blue-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-secondary);">{{ $stats['totalRooms'] }}</div>
                        <div class="stat-label">Total Rooms</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-blue"><i class="bi bi-building"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm green-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-success);">{{ $stats['availableRooms'] }}</div>
                        <div class="stat-label">Available</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-green"><i class="bi bi-door-open"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">{{ $stats['occupiedRooms'] }}</div>
                        <div class="stat-label">Occupied</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-people"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm red-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-error);">{{ $stats['maintenanceRooms'] }}</div>
                        <div class="stat-label">Maintenance</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-red"><i class="bi bi-tools"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Operations --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm cyan-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:#06b6d4;">{{ $stats['todayBookings'] }}</div>
                        <div class="stat-label">Today's Bookings</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-cyan"><i class="bi bi-calendar-plus"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">{{ $stats['todayCheckIns'] }}</div>
                        <div class="stat-label">Today's Check-ins</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-box-arrow-in-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm purple-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:#8b5cf6;">{{ $stats['todayCheckOuts'] }}</div>
                        <div class="stat-label">Today's Check-outs</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-purple"><i class="bi bi-box-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">${{ number_format($stats['monthlyRevenue'], 0) }}</div>
                        <div class="stat-label">Monthly Revenue</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-currency-dollar"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm green-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-success);">${{ number_format($stats['annualRevenue'], 0) }}</div>
                        <div class="stat-label">Annual Revenue</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-green"><i class="bi bi-graph-up-arrow"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-white shadow-sm blue-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-secondary);">${{ number_format($stats['totalRevenue'], 0) }}</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-blue"><i class="bi bi-piggy-bank"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100 chart-card">
                <div class="card-header"><i class="bi bi-bar-chart-fill me-1"></i> Revenue Trend (12 months)</div>
                <div class="card-body"><canvas id="revenueChart" height="200"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100 chart-card">
                <div class="card-header"><i class="bi bi-activity me-1"></i> Occupancy (30 days)</div>
                <div class="card-body"><canvas id="occupancyChart" height="200"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Status + Recent Data --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100 chart-card">
                <div class="card-header"><i class="bi bi-pie-chart me-1"></i> Booking Status</div>
                <div class="card-body"><canvas id="statusChart" height="200"></canvas></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 chart-card">
                <div class="card-header"><i class="bi bi-people me-1"></i> Recent Customers</div>
                <div class="list-group list-group-flush">
                    @forelse ($stats['recentCustomers'] as $c)
                        <div class="list-group-item d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 stat-icon-navy" style="width:36px;height:36px;font-size:.75rem;font-weight:600;">
                                {{ substr($c->name, 0, 1) }}
                            </div>
                            <div>
                                <strong class="small" style="color:var(--lp-text);">{{ $c->name }}</strong>
                                <small class="d-block text-muted">{{ $c->email }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-people d-block mb-1" style="font-size:1.5rem;"></i> No customers yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 chart-card">
                <div class="card-header"><i class="bi bi-clock-history me-1"></i> Recent Bookings</div>
                <div class="list-group list-group-flush">
                    @forelse ($stats['recentBookings'] as $b)
                        <a href="{{ route('admin.manage-bookings.show', $b) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="small" style="color:var(--lp-text);">{{ $b->booking_number }}</strong>
                                    <small class="d-block text-muted">{{ $b->hotel->name }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge-status bg-{{ $b->status }}">{{ ucfirst(str_replace('_', ' ', $b->status)) }}</span>
                                    <small class="d-block text-muted mt-1">${{ number_format($b->total_amount, 2) }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-calendar d-block mb-1" style="font-size:1.5rem;"></i> No bookings yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: @json($revenueChart['labels']),
                datasets: [{ label: 'Revenue ($)', data: @json($revenueChart['data']), backgroundColor: '#c89a3c' }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('occupancyChart'), {
            type: 'line',
            data: {
                labels: @json($occupancyChart['labels']),
                datasets: [
                    { label: 'Occupied', data: @json($occupancyChart['occupied']), borderColor: '#c89a3c', backgroundColor: 'rgba(200,154,60,.1)', fill: true },
                    { label: 'Available', data: @json($occupancyChart['available']), borderColor: '#1a2332', backgroundColor: 'rgba(26,35,50,.1)', fill: true }
                ]
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Cancelled', 'Expired'],
                datasets: [{
                    data: [{{ $bookingStatuses['pending'] }}, {{ $bookingStatuses['confirmed'] }}, {{ $bookingStatuses['checked_in'] }}, {{ $bookingStatuses['checked_out'] }}, {{ $bookingStatuses['cancelled'] }}, {{ $bookingStatuses['expired'] }}],
                    backgroundColor: ['#fff3cd','#d1e7dd','#cff4fc','#e2e3e5','#f8d7da','#1a2332']
                }]
            }
        });
    </script>
    @endpush
</x-app-layout>
