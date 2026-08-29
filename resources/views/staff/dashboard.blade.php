<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-speedometer2 me-2"></i>{{ $isManager ? 'Manager' : 'Receptionist' }} Dashboard</h2>
            <span class="badge bg-gold text-dark px-3 py-2" style="background:#c89a3c;">{{ now()->format('l, F d, Y') }}</span>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card bg-white shadow-sm h-100 gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">{{ $todayCheckIns }}</div>
                        <div class="stat-label">Today's Check-ins</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-box-arrow-in-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card bg-white shadow-sm h-100 cyan-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:#06b6d4;">{{ $todayCheckOuts }}</div>
                        <div class="stat-label">Today's Check-outs</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-cyan"><i class="bi bi-box-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card bg-white shadow-sm h-100 gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">{{ $pendingBookings }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-clock-history"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card bg-white shadow-sm h-100 green-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-success);">{{ $availableRooms }} <small class="fs-6 text-muted">/ {{ $totalRooms }}</small></div>
                        <div class="stat-label">Rooms Available</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-green"><i class="bi bi-door-open"></i></div>
                </div>
            </div>
        </div>
        @if ($isManager)
            <div class="col-md-3 col-6">
                <div class="stat-card bg-white shadow-sm h-100 gold-left">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="color:var(--lp-accent);">${{ number_format($monthlyRevenue, 0) }}</div>
                            <div class="stat-label">Monthly Revenue</div>
                        </div>
                        <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-white shadow-sm h-100 green-left">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="color:var(--lp-success);">{{ $occupancyRate }}%</div>
                            <div class="stat-label">Occupancy Rate</div>
                        </div>
                        <div class="stat-icon-bg stat-icon-green"><i class="bi bi-graph-up-arrow"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-white shadow-sm h-100 blue-left">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="color:var(--lp-secondary);">{{ $totalBookings }}</div>
                            <div class="stat-label">Total Bookings</div>
                        </div>
                        <div class="stat-icon-bg stat-icon-blue"><i class="bi bi-calendar-check"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-white shadow-sm h-100 cyan-left">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="color:#06b6d4;">{{ $todayBookings }}</div>
                            <div class="stat-label">New Today</div>
                        </div>
                        <div class="stat-icon-bg stat-icon-cyan"><i class="bi bi-plus-circle"></i></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Action Cards --}}
    <h5 class="fw-bold mb-3" style="color:var(--lp-text);"><i class="bi bi-grid me-1"></i> Quick Actions</h5>
    <div class="row g-3 mb-4">
        @if (!$isManager)
            {{-- Receptionist Cards --}}
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index', ['status' => 'confirmed', 'check_in' => now()->format('Y-m-d')]) }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gold">
                        <div class="module-icon-bg module-icon-gold"><i class="bi bi-box-arrow-in-right"></i></div>
                        <h6>Today's Check-ins</h6>
                        <p>Process guest check-ins for today</p>
                        <span class="small fw-bold" style="color:var(--lp-accent);">{{ $todayCheckIns }} pending →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index', ['status' => 'checked_in']) }}" class="text-decoration-none">
                    <div class="module-card bg-white border-cyan">
                        <div class="module-icon-bg module-icon-cyan"><i class="bi bi-box-arrow-right"></i></div>
                        <h6>Today's Check-outs</h6>
                        <p>Process guest check-outs</p>
                        <span class="small fw-bold" style="color:#06b6d4;">{{ $todayCheckOuts }} pending →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gold">
                        <div class="module-icon-bg module-icon-gold"><i class="bi bi-clock-history"></i></div>
                        <h6>Pending Bookings</h6>
                        <p>Review and confirm pending requests</p>
                        <span class="small fw-bold" style="color:var(--lp-accent);">{{ $pendingBookings }} pending →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-green">
                        <div class="module-icon-bg module-icon-green"><i class="bi bi-calendar-check"></i></div>
                        <h6>All Bookings</h6>
                        <p>View and manage all reservations</p>
                        <span class="small fw-bold" style="color:var(--lp-success);">Manage →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.hotels.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-blue">
                        <div class="module-icon-bg module-icon-blue"><i class="bi bi-door-open"></i></div>
                        <h6>Room Availability</h6>
                        <p>View room status and assignments</p>
                        <span class="small fw-bold" style="color:var(--lp-secondary);">{{ $availableRooms }} available →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-purple">
                        <div class="module-icon-bg module-icon-purple"><i class="bi bi-person-badge"></i></div>
                        <h6>Guest Lookup</h6>
                        <p>Search and find guest information</p>
                        <span class="small fw-bold" style="color:#8b5cf6;">Search →</span>
                    </div>
                </a>
            </div>
        @else
            {{-- Manager Cards --}}
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.hotels.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-blue">
                        <div class="module-icon-bg module-icon-blue"><i class="bi bi-building"></i></div>
                        <h6>Rooms &amp; Types</h6>
                        <p>Manage hotels, room types, and rooms</p>
                        <span class="small fw-bold" style="color:var(--lp-secondary);">Manage →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gold">
                        <div class="module-icon-bg module-icon-gold"><i class="bi bi-calendar-check"></i></div>
                        <h6>Booking Overview</h6>
                        <p>View and manage all bookings</p>
                        <span class="small fw-bold" style="color:var(--lp-accent);">{{ $totalBookings }} total →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.payments.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-green">
                        <div class="module-icon-bg module-icon-green"><i class="bi bi-credit-card"></i></div>
                        <h6>Payment Overview</h6>
                        <p>View all transactions and receipts</p>
                        <span class="small fw-bold" style="color:var(--lp-success);">${{ number_format($monthlyRevenue, 0) }} this month →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.employees.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-cyan">
                        <div class="module-icon-bg module-icon-cyan"><i class="bi bi-people"></i></div>
                        <h6>Employees</h6>
                        <p>Manage staff and their assignments</p>
                        <span class="small fw-bold" style="color:#06b6d4;">Manage →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.discounts.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gold">
                        <div class="module-icon-bg module-icon-gold"><i class="bi bi-tags"></i></div>
                        <h6>Discounts</h6>
                        <p>Manage promotional codes and offers</p>
                        <span class="small fw-bold" style="color:var(--lp-accent);">Manage →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-red">
                        <div class="module-icon-bg module-icon-red"><i class="bi bi-graph-up"></i></div>
                        <h6>Reports</h6>
                        <p>Revenue, occupancy, and performance</p>
                        <span class="small fw-bold" style="color:var(--lp-error);">View Reports →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('search') }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gray">
                        <div class="module-icon-bg module-icon-gray"><i class="bi bi-search"></i></div>
                        <h6>Search Availability</h6>
                        <p>Check real-time room availability</p>
                        <span class="small fw-bold" style="color:#64748b;">Search →</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('admin.manage-bookings.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="module-card bg-white border-gold">
                        <div class="module-icon-bg module-icon-gold"><i class="bi bi-clock-history"></i></div>
                        <h6>Pending Actions</h6>
                        <p>Bookings awaiting confirmation</p>
                        <span class="small fw-bold" style="color:var(--lp-accent);">{{ $pendingBookings }} pending →</span>
                    </div>
                </a>
            </div>
        @endif
    </div>

    @if ($isManager && !empty($recentBookings) && $recentBookings->isNotEmpty())
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-1"></i> Recent Bookings</span>
                <a href="{{ route('admin.manage-bookings.index') }}" class="btn btn-sm btn-outline-navy">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booking #</th>
                                <th>Guest</th>
                                <th>Hotel</th>
                                <th>Dates</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentBookings as $b)
                                <tr>
                                    <td><a href="{{ route('admin.manage-bookings.show', $b) }}" class="fw-bold text-decoration-none">{{ $b->booking_number }}</a></td>
                                    <td>{{ $b->user->name }}</td>
                                    <td>{{ $b->hotel->name }}</td>
                                    <td><small>{{ $b->check_in->format('M d') }} – {{ $b->check_out->format('M d, Y') }}</small></td>
                                    <td class="text-end">${{ number_format($b->total_amount, 2) }}</td>
                                    <td><span class="badge-status bg-{{ $b->status }}">{{ ucfirst(str_replace('_', ' ', $b->status)) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
