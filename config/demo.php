<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, developer-oriented conveniences become available:
    |
    * Seeding demo user accounts (also available whenever the app runs
    *   in the "local" environment).
    * A "Demo Accounts" quick-pick section on the login page.
    * A clearly-labelled "DEVELOPMENT ONLY — OTP" display on the MFA page.
    |
    | The OTP display is additionally gated behind the "local" environment
    | and is therefore never rendered in production, regardless of this flag.
    |
    */

    'enabled' => (bool) env('DEMO_MODE', false),
];
