<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Hotel Manager',
                'slug' => 'hotel-manager',
                'description' => 'Manages hotel operations, staff, and reports',
            ],
            [
                'name' => 'Receptionist',
                'slug' => 'receptionist',
                'description' => 'Handles front desk, bookings, and check-in/out',
            ],
            [
                'name' => 'Registered Customer',
                'slug' => 'registered-customer',
                'description' => 'Standard customer with booking privileges',
            ],
        ];

        $permissions = [
            ['name' => 'Manage Hotels', 'slug' => 'manage-hotels'],
            ['name' => 'Manage Room Types', 'slug' => 'manage-room-types'],
            ['name' => 'Manage Rooms', 'slug' => 'manage-rooms'],
            ['name' => 'Manage Amenities', 'slug' => 'manage-amenities'],
            ['name' => 'Manage Employees', 'slug' => 'manage-employees'],
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
            ['name' => 'View Reports', 'slug' => 'view-reports'],
            ['name' => 'Create Booking', 'slug' => 'create-booking'],
            ['name' => 'View All Bookings', 'slug' => 'view-all-bookings'],
            ['name' => 'Cancel Booking', 'slug' => 'cancel-booking'],
            ['name' => 'Check In Guest', 'slug' => 'check-in-guest'],
            ['name' => 'Check Out Guest', 'slug' => 'check-out-guest'],
            ['name' => 'Manage Room Status', 'slug' => 'manage-room-status'],
            ['name' => 'Process Payments', 'slug' => 'process-payments'],
            ['name' => 'Approve Reviews', 'slug' => 'approve-reviews'],
            ['name' => 'View Audit Logs', 'slug' => 'view-audit-logs'],
            ['name' => 'Leave Review', 'slug' => 'leave-review'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']],
                [
                    'name' => $perm['name'],
                    'guard_name' => 'web',
                ]
            );
        }

        $adminPerms = Permission::all()->pluck('id');
        $managerPerms = Permission::whereIn('slug', [
            'manage-hotels', 'manage-room-types', 'manage-rooms',
            'manage-amenities', 'manage-employees', 'view-reports',
            'view-all-bookings', 'approve-reviews', 'create-booking',
            'cancel-booking', 'check-in-guest', 'check-out-guest',
            'manage-room-status', 'process-payments',
        ])->pluck('id');
        $receptionistPerms = Permission::whereIn('slug', [
            'create-booking', 'cancel-booking', 'check-in-guest',
            'check-out-guest', 'manage-room-status', 'process-payments',
            'view-all-bookings',
        ])->pluck('id');
        $customerPerms = Permission::whereIn('slug', [
            'create-booking', 'cancel-booking', 'leave-review',
        ])->pluck('id');

        $rolePermMap = [
            'administrator' => $adminPerms,
            'hotel-manager' => $managerPerms,
            'receptionist' => $receptionistPerms,
            'registered-customer' => $customerPerms,
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                [
                    'name' => $roleData['name'],
                    'description' => $roleData['description'],
                    'guard_name' => 'web',
                ]
            );
            $role->permissions()->sync($rolePermMap[$roleData['slug']]);
        }
    }
}
