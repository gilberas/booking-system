<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'create-booking', 'manage-hotels', 'manage-users',
            'process-payments', 'view-reports', 'manage-rooms',
        ]);

        return [
            'name' => Str::title(str_replace('-', ' ', $name)),
            'slug' => $name,
            'description' => fake()->sentence(),
            'guard_name' => 'web',
        ];
    }
}
