<?php

namespace App\Console\Commands;

use App\Models\MfaChallenge;
use Illuminate\Console\Command;

class PruneMfaChallenges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mfa:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired and consumed MFA challenges';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $deleted = MfaChallenge::query()
            ->where(function ($query) {
                $query->where('expires_at', '<', now())
                    ->orWhereNotNull('used_at');
            })
            ->delete();

        $this->info("Deleted {$deleted} expired or consumed MFA challenge(s).");

        return self::SUCCESS;
    }
}
