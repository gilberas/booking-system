<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'hotel_id' => Hotel::factory(),
            'employee_code' => 'EMP-'.strtoupper(Str::random(8)),
            'position' => fake()->randomElement([
                'Receptionist', 'Housekeeper', 'Front Desk Manager',
                'Concierge', 'Bellboy', 'Hotel Manager',
            ]),
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'salary' => fake()->randomFloat(2, 25000, 85000),
            'emergency_contact' => [
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'relationship' => fake()->randomElement(['Spouse', 'Parent', 'Sibling', 'Friend']),
            ],
            'is_active' => true,
        ];
    }
}
