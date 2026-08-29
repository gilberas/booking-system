<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createRole(string $slug): Role
    {
        return Role::create([
            'name' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
        ]);
    }

    private function userWithRole(string $slug): User
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->createRole($slug));

        return $user;
    }

    public function test_dashboard_route_redirects_by_role(): void
    {
        $this->actingAs($this->userWithRole('administrator'));
        $this->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));

        $this->actingAs($this->userWithRole('hotel-manager'));
        $this->get(route('dashboard'))->assertRedirect(route('staff.dashboard'));

        $this->actingAs($this->userWithRole('receptionist'));
        $this->get(route('dashboard'))->assertRedirect(route('staff.dashboard'));

        $this->actingAs($this->userWithRole('registered-customer'));
        $this->get(route('dashboard'))->assertRedirect(route('customer.dashboard'));
    }

    public function test_administrators_can_reach_the_admin_dashboard(): void
    {
        $this->actingAs($this->userWithRole('administrator'));

        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_non_administrators_cannot_reach_the_admin_dashboard(): void
    {
        $this->actingAs($this->userWithRole('registered-customer'));

        $this->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_managers_cannot_reach_admin_only_pages(): void
    {
        $this->actingAs($this->userWithRole('hotel-manager'));

        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('admin.employees.index'))->assertOk();
    }

    public function test_customers_cannot_reach_manager_pages(): void
    {
        $this->actingAs($this->userWithRole('registered-customer'));

        $this->get(route('admin.employees.index'))->assertForbidden();
    }

    public function test_receptionists_can_reach_the_staff_dashboard(): void
    {
        $this->actingAs($this->userWithRole('receptionist'));

        $this->get(route('staff.dashboard'))->assertOk();
    }

    public function test_customers_cannot_reach_the_staff_dashboard(): void
    {
        $this->actingAs($this->userWithRole('registered-customer'));

        $this->get(route('staff.dashboard'))->assertForbidden();
    }

    public function test_unauthenticated_users_are_redirected_on_protected_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('customer.dashboard'))->assertRedirect(route('login'));
    }
}
