<nav class="navbar navbar-expand-lg navbar-dark bg-navy shadow-sm px-0">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-building me-1 text-gold"></i> {{ config('app.name') }}
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('search') ? 'active' : '' }}" href="{{ route('search') }}">
                        <i class="bi bi-search"></i> Search Rooms
                    </a>
                </li>

                @role('administrator')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-lock"></i> Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Management</li>
                            <li><a class="dropdown-item" href="{{ route('admin.hotels.index') }}"><i class="bi bi-building"></i> Hotels</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.amenities.index') }}"><i class="bi bi-grid-3x3-gap"></i> Amenities</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.employees.index') }}"><i class="bi bi-people"></i> Employees</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}"><i class="bi bi-person-badge"></i> Customers</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Operations</li>
                            <li><a class="dropdown-item" href="{{ route('admin.manage-bookings.index') }}"><i class="bi bi-calendar-check"></i> Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.payments.index') }}"><i class="bi bi-credit-card"></i> Payments</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Reports</li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}"><i class="bi bi-graph-up"></i> Reports</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Configuration</li>
                            <li><a class="dropdown-item" href="{{ route('admin.discounts.index') }}"><i class="bi bi-tags"></i> Discounts</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.contents.index') }}"><i class="bi bi-file-text"></i> Content</a></li>
                        </ul>
                    </li>
                @endrole

                @role('hotel-manager')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('staff.*', 'admin.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-briefcase"></i> Manager
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hotels.index') }}"><i class="bi bi-building"></i> Hotels &amp; Rooms</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.manage-bookings.index') }}"><i class="bi bi-calendar-check"></i> All Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.payments.index') }}"><i class="bi bi-credit-card"></i> Payments</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.employees.index') }}"><i class="bi bi-people"></i> Employees</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.discounts.index') }}"><i class="bi bi-tags"></i> Discounts</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}"><i class="bi bi-graph-up"></i> Reports</a></li>
                        </ul>
                    </li>
                @endrole

                @role('receptionist')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-workspace"></i> Reception
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.manage-bookings.index') }}"><i class="bi bi-calendar-check"></i> Manage Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}"><i class="bi bi-person-badge"></i> Guest Lookup</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.hotels.index') }}"><i class="bi bi-building"></i> Room Availability</a></li>
                        </ul>
                    </li>
                @endrole

                @role('registered-customer')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('customer.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> My Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.bookings.index') }}"><i class="bi bi-calendar3"></i> My Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}"><i class="bi bi-gear"></i> Profile</a></li>
                        </ul>
                    </li>
                @endrole
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-gold btn-sm" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
