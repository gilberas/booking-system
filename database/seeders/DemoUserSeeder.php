<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Support\Demo;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    /**
     * Demo accounts used to demonstrate the Booking System during
     * development. They are only seeded in a local environment or when
     * demo mode is enabled — never in production.
     */
    public function run(): void
    {
        if (! Demo::seedingEnabled()) {
            return;
        }

        $accounts = [
            ['name' => 'Demo Administrator', 'email' => 'admin@demo.test', 'role' => 'administrator'],
            ['name' => 'Demo Hotel Manager', 'email' => 'manager@demo.test', 'role' => 'hotel-manager'],
            ['name' => 'Demo Receptionist', 'email' => 'staff@demo.test', 'role' => 'receptionist'],
            ['name' => 'Demo Customer', 'email' => 'customer@demo.test', 'role' => 'registered-customer'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'email_verified_at' => now(),
                    'password' => Demo::password(),
                    'is_active' => true,
                ]
            );

            $role = Role::where('slug', $account['role'])->first();

            if ($role && ! $user->roles()->where('role_id', $role->id)->exists()) {
                $user->roles()->attach($role->id);
            }
        }
    }
}
