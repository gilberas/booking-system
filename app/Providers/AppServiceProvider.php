<?php

namespace App\Providers;

use App\Services\Audit\AuditLogService;
use App\Services\Booking\BookingService;
use App\Services\Payment\PaymentService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuditLogService::class);
        $this->app->singleton(BookingService::class);
        $this->app->singleton(PaymentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureBladeDirectives();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        // utf8mb4 stores up to 4 bytes per character; without an explicit
        // length, varchar(255) would exceed MySQL's InnoDB key length limit.
        Schema::defaultStringLength(191);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    private function configureBladeDirectives(): void
    {
        Blade::if('role', fn (string $role) => auth()->check() && auth()->user()->hasRole($role));
        Blade::if('permission', fn (string $permission) => auth()->check() && auth()->user()->hasPermission($permission));
    }
}
