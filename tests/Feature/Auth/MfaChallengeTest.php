<?php

namespace Tests\Feature\Auth;

use App\Models\MfaChallenge;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use App\Services\MfaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MfaChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_mfa_verification_page_requires_a_pending_challenge(): void
    {
        $this->get(route('mfa.verify'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('mfa');
    }

    public function test_login_creates_a_pending_challenge_and_sends_the_otp(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $this->assertDatabaseHas('mfa_challenges', [
            'user_id' => $user->id,
            'used_at' => null,
        ]);

        Notification::assertSentTo($user, SendOtpNotification::class);
    }

    public function test_incorrect_otp_is_rejected(): void
    {
        $service = app(MfaService::class);
        $user = User::factory()->create();
        $challenge = $service->createChallenge($user, '123456');

        $this->withSession(['mfa.challenge_token' => $challenge->challenge_token])
            ->from('/mfa/verify')
            ->post('/mfa/verify', ['code' => '000000'])
            ->assertSessionHasErrors('mfa');

        $this->assertGuest();
    }

    public function test_otp_can_only_be_used_once(): void
    {
        $service = app(MfaService::class);
        $user = User::factory()->create();
        $challenge = $service->createChallenge($user, '123456');

        $this->withSession(['mfa.challenge_token' => $challenge->challenge_token]);

        $this->post('/mfa/verify', ['code' => '123456'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->assertSame(MfaService::USED, $service->verify($challenge->fresh(), '123456'));
    }

    public function test_expired_otp_is_rejected_and_invalidated(): void
    {
        $service = app(MfaService::class);
        $user = User::factory()->create();
        $challenge = $service->createChallenge($user, '123456');

        MfaChallenge::where('id', $challenge->id)->update(['expires_at' => now()->subMinute()]);

        $this->withSession(['mfa.challenge_token' => $challenge->challenge_token])
            ->from('/mfa/verify')
            ->post('/mfa/verify', ['code' => '123456'])
            ->assertSessionHasErrors('mfa');

        $this->assertGuest();
        $this->assertNotNull($challenge->fresh()->used_at);
    }

    public function test_challenge_is_locked_after_max_attempts(): void
    {
        config(['mfa.max_attempts' => 3]);

        $service = app(MfaService::class);
        $user = User::factory()->create();
        $challenge = $service->createChallenge($user, '123456');

        $this->withSession(['mfa.challenge_token' => $challenge->challenge_token]);

        for ($i = 0; $i < 3; $i++) {
            $this->from('/mfa/verify')
                ->post('/mfa/verify', ['code' => '000000'])
                ->assertSessionHasErrors('mfa');
        }

        $this->assertGuest();
        $this->assertNotNull($challenge->fresh()->used_at);
    }

    public function test_resend_issues_a_new_code_and_invalidates_the_previous(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $first = Notification::sent($user, SendOtpNotification::class)->first();

        $this->post('/mfa/resend')->assertRedirect(route('mfa.verify'));

        $second = Notification::sent($user, SendOtpNotification::class)->last();

        $this->assertNotSame($first->otp(), $second->otp());

        $this->from('/mfa/verify')
            ->post('/mfa/verify', ['code' => $first->otp()])
            ->assertSessionHasErrors('mfa');

        $this->post('/mfa/verify', ['code' => $second->otp()])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_resend_countdown_blocks_resending_immediately_after_a_resend(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $this->post('/mfa/resend')->assertRedirect(route('mfa.verify'));

        $this->from('/mfa/verify')
            ->post('/mfa/resend')
            ->assertSessionHasErrors('mfa');
    }

    public function test_demo_otp_is_not_displayed_when_demo_mode_is_disabled(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $this->get(route('mfa.verify'))->assertDontSee('DEVELOPMENT ONLY');

        config(['demo.enabled' => true]);

        // Non-local environments never surface the OTP, even with demo mode on.
        $this->get(route('mfa.verify'))->assertDontSee('DEVELOPMENT ONLY');
    }

    public function test_demo_otp_is_displayed_only_in_local_demo_mode(): void
    {
        Notification::fake();

        config(['demo.enabled' => true, 'app.env' => 'local']);

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $this->get(route('mfa.verify'))
            ->assertOk()
            ->assertSee('DEVELOPMENT ONLY')
            ->assertSee(Notification::sent($user, SendOtpNotification::class)->first()->otp());
    }
}
