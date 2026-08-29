<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MFA / OTP Configuration
    |--------------------------------------------------------------------------
    |
    | These settings control the email-based multi-factor authentication
    | challenge. The OTP is never stored in plain text — only a hash is
    | persisted. Values can be overridden through environment variables.
    |
    */

    'otp_length' => (int) env('MFA_OTP_LENGTH', 6),

    'otp_ttl_minutes' => (int) env('MFA_OTP_TTL_MINUTES', 5),

    'max_attempts' => (int) env('MFA_MAX_ATTEMPTS', 5),

    'resend_cooldown_seconds' => (int) env('MFA_RESEND_COOLDOWN_SECONDS', 45),
];
