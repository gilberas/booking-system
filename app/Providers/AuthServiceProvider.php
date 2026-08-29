<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin', fn (User $user) => $user->hasRole('administrator'));
        Gate::define('manager', fn (User $user) => $user->hasRole('hotel-manager'));
        Gate::define('receptionist', fn (User $user) => $user->hasRole('receptionist'));
        Gate::define('customer', fn (User $user) => $user->hasRole('registered-customer'));

        Gate::define('staff', fn (User $user) => $user->hasRole(['administrator', 'hotel-manager', 'receptionist']));
    }
}
