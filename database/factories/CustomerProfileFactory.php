<?php

namespace Database\Factories;

use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerProfile>
 */
class CustomerProfileFactory extends Factory
{
    protected $model = CustomerProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date_of_birth' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'nationality' => fake()->country(),
            'id_proof_type' => fake()->randomElement(['passport', 'dl', 'national_id']),
            'id_proof_number' => strtoupper(fake()->bothify('??######')),
            'phone_secondary' => fake()->optional(0.5)->phoneNumber(),
            'preferred_language' => fake()->randomElement(['en', 'es', 'fr', 'de', 'ja']),
            'special_requests' => fake()->optional(0.3)->sentence(),
        ];
    }
}
