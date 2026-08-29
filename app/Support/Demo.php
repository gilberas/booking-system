<?php

namespace App\Support;

/**
 * Centralises the demo/development mode decisions so that the rules are
 * enforced on the backend and can be tested deterministically.
 */
final class Demo
{
    /**
     * Whether demo mode is switched on through DEMO_MODE.
     */
    public static function enabled(): bool
    {
        return (bool) config('demo.enabled', false);
    }

    /**
     * Whether the application is running in the local environment.
     */
    public static function isLocal(): bool
    {
        return config('app.env') === 'local';
    }

    /**
     * Whether demo user accounts may be seeded.
     *
     * Demo users are seeded in local development, or whenever demo mode
     * is enabled outside of production. They are never seeded in production.
     */
    public static function seedingEnabled(): bool
    {
        return self::isLocal() || self::enabled();
    }

    /**
     * Whether the "Demo Accounts" picker may appear on the login page.
     */
    public static function loginUiEnabled(): bool
    {
        return self::enabled() && config('app.env') !== 'production';
    }

    /**
     * Whether the OTP may be surfaced in the developer-only interface on
     * the MFA page. This requires BOTH demo mode and a local environment.
     *
     * In production this is always false regardless of DEMO_MODE.
     */
    public static function otpDisplayEnabled(): bool
    {
        return self::isLocal() && self::enabled();
    }

    /**
     * Demo account email address for a given role slug.
     */
    public static function emailFor(string $roleSlug): string
    {
        return match ($roleSlug) {
            'administrator' => 'admin@demo.test',
            'hotel-manager' => 'manager@demo.test',
            'receptionist' => 'staff@demo.test',
            'registered-customer' => 'customer@demo.test',
            default => 'customer@demo.test',
        };
    }

    /**
     * Demo account password (documented for development only).
     */
    public static function password(): string
    {
        return 'Password123!';
    }
}
