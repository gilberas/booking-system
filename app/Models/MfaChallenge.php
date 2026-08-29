<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $challenge_token
 * @property string $otp_hash
 * @property Carbon $expires_at
 * @property int $attempts
 * @property int $max_attempts
 * @property Carbon|null $used_at
 * @property Carbon|null $resend_available_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MfaChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_token',
        'otp_hash',
        'expires_at',
        'attempts',
        'max_attempts',
        'used_at',
        'resend_available_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'attempts' => 'integer',
            'max_attempts' => 'integer',
            'used_at' => 'datetime',
            'resend_available_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->used_at === null && $this->expires_at->isFuture();
    }
}
