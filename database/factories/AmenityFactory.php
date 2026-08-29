<?php

namespace Database\Factories;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Amenity>
 */
class AmenityFactory extends Factory
{
    protected $model = Amenity::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'WiFi', 'Air Conditioner', 'Television', 'Mini Bar', 'Parking',
            'Breakfast', 'Swimming Pool', 'Gym', 'Laundry', 'Balcony',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement(['wifi', 'snowflake', 'tv', 'glass', 'car', 'coffee', 'pool', 'dumbbell', 'shirt', 'tree']),
            'category' => fake()->randomElement(['bathroom', 'food', 'entertainment', 'business']),
        ];
    }
}
