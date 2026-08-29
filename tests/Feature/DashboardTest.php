<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_are_redirected_to_their_role_dashboard(): void
    {
        $role = Role::create([
            'name' => 'Registered Customer',
            'slug' => 'registered-customer',
        ]);

        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user);

        $this->get(route('dashboard'))->assertRedirect(route('customer.dashboard'));

        $this->get(route('customer.dashboard'))->assertOk();
    }
}
