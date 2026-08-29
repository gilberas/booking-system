<?php

namespace App\Services;

use App\Models\MfaChallenge;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MfaService
{
    public const SUCCESS = 'success';

    public const INVALID = 'invalid';

    public const EXPIRED = 'expired';

    public const USED = 'used';

    public const LOCKED = 'locked';

    /**
     * Generate a cryptographically-secure numeric OTP.
     */
    public function generateOtp(): string
    {
        $length = max(1, (int) config('mfa.otp_length', 6));

        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_repeat('9', $length);

        return (string) random_int($min, $max);
    }

    /**
     * Create a new authentication challenge for the user.
     *
     * Any previously pending challenge for the same user is invalidated so
     * that a freshly generated OTP always supersedes older ones. Only the
     * hash of the OTP is persisted — the plain value is never stored.
     */
    public function createChallenge(User $user, string $otp): MfaChallenge
    {
        MfaChallenge::query()
            ->where('user_id', $user->id)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        return MfaChallenge::create([
            'user_id' => $user->id,
            'challenge_token' => Str::random(64),
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes((int) config('mfa.otp_ttl_minutes', 5)),
            'attempts' => 0,
            'max_attempts' => (int) config('mfa.max_attempts', 5),
        ]);
    }

    /**
     * Issue a fresh OTP for the same challenge (resend).
     *
     * The previous OTP is invalidated because its hash is replaced.
     */
    public function refreshChallenge(MfaChallenge $challenge, string $otp): MfaChallenge
    {
        $challenge->update([
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes((int) config('mfa.otp_ttl_minutes', 5)),
            'attempts' => 0,
            'used_at' => null,
            'resend_available_at' => now()->addSeconds((int) config('mfa.resend_cooldown_seconds', 45)),
        ]);

        return $challenge->fresh();
    }

    /**
     * Verify a submitted code against the challenge.
     *
     * @return string one of the MfaService result constants
     */
    public function verify(MfaChallenge $challenge, string $code): string
    {
        if ($challenge->used_at !== null) {
            return self::USED;
        }

        if ($challenge->expires_at->isPast()) {
            return self::EXPIRED;
        }

        if ($challenge->attempts >= $challenge->max_attempts) {
            return self::LOCKED;
        }

        if (Hash::check($code, $challenge->otp_hash)) {
            return self::SUCCESS;
        }

        $challenge->increment('attempts');

        if ($challenge->fresh()->attempts >= $challenge->max_attempts) {
            $challenge->update(['used_at' => now()]);

            return self::LOCKED;
        }

        return self::INVALID;
    }

    /**
     * Mark a challenge as consumed (single-use).
     */
    public function markUsed(MfaChallenge $challenge): void
    {
        $challenge->update(['used_at' => now()]);
    }

    /**
     * Invalidate a challenge that can no longer be used.
     */
    public function invalidate(MfaChallenge $challenge): void
    {
        $this->markUsed($challenge);
    }

    /**
     * Seconds remaining before the user may request a new code.
     */
    public function resendCooldownSeconds(MfaChallenge $challenge): int
    {
        $availableAt = $challenge->resend_available_at;

        if ($availableAt === null) {
            return 0;
        }

        return max(0, (int) ceil($availableAt->timestamp - now()->timestamp));
    }
}
