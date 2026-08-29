<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('mfa.verify'));

        $this->assertGuest();

        Notification::assertSentTo($user, SendOtpNotification::class, function (SendOtpNotification $notification) use ($user) {
            $this->post('/mfa/verify', ['code' => $notification->otp()])
                ->assertRedirect(route('dashboard'));

            $this->assertAuthenticatedAs($user);

            return true;
        });
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_uses_a_generic_error_for_unknown_emails(): void
    {
        $this->post('/login', [
            'email' => 'nobody@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertSame(trans('auth.failed'), session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_inactive_users_cannot_authenticate(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_multiple_failed_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'locked@example.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/login', [
            'email' => 'locked@example.com',
            'password' => 'wrong-password',
        ])
            ->assertSessionHasErrors('email');

        $this->assertStringContainsString('Too many login attempts.', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
