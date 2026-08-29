<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-person-circle me-2"></i>My Dashboard</h2>
            <span class="badge px-3 py-2" style="background:#c89a3c;color:#1a2332;">Welcome, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
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
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm h-100 gold-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-accent);">{{ $upcomingCount }}</div>
                        <div class="stat-label">Upcoming</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-gold"><i class="bi bi-clock-history"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm h-100 green-left">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value" style="color:var(--lp-success);">{{ $completedCount }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-icon-bg stat-icon-green"><i class="bi bi-check-circle"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white shadow-sm h-100 d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-navy btn-sm w-100 mb-1"><i class="bi bi-list"></i> My Bookings</a>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-gold btn-sm w-100"><i class="bi bi-gear"></i> Profile</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Currently Staying --}}
    @if ($active->isNotEmpty())
            <div class="card shadow-sm mb-4 border-0 border-start border-warning border-4">
                <div class="card-header" style="background:var(--lp-bg);">
                <span class="fw-bold"><i class="bi bi-building me-1"></i> Currently Staying</span>
            </div>
            <div class="list-group list-group-flush">
                @foreach ($active as $booking)
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $booking->hotel->name }}</strong>
                            <small class="text-muted d-block">Check-out {{ $booking->check_out->format('M d, Y') }}</small>
                        </div>
                        <span class="badge-status bg-checked-in">Checked In</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Upcoming & Past Bookings --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar3 me-1"></i> Upcoming Bookings</span>
                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-navy">View all</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($upcoming as $booking)
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $booking->hotel->name }}</strong>
                                    <small class="text-muted d-block">{{ $booking->check_in->format('M d, Y') }} – {{ $booking->check_out->format('M d, Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge-status bg-{{ $booking->status === 'confirmed' ? 'confirmed' : 'pending' }}">{{ ucfirst($booking->status) }}</span>
                                    <small class="d-block text-muted mt-1">${{ number_format($booking->total_amount, 2) }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-calendar-plus d-block mb-2" style="font-size:2rem;"></i>
                            No upcoming bookings.
                            <a href="{{ route('search') }}" class="d-block mt-2 btn btn-gold btn-sm">Search Rooms</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock-history me-1"></i> Past Bookings</span>
                    <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-navy">View all</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($past as $booking)
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $booking->hotel->name }}</strong>
                                    <small class="text-muted d-block">{{ $booking->check_in->format('M d, Y') }} – {{ $booking->check_out->format('M d, Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge-status bg-{{ $booking->status === 'checked_out' ? 'checked-out' : ($booking->status === 'cancelled' ? 'cancelled' : 'expired') }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                    <small class="d-block text-muted mt-1">${{ number_format($booking->total_amount, 2) }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-inbox d-block mb-2" style="font-size:2rem;"></i>
                            No past bookings yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
