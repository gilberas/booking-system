<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'hotel_id' => fn (array $attrs) => RoomType::find($attrs['room_type_id'])->hotel_id,
            'room_number' => fn (array $attrs) => $attrs['hotel_id'].sprintf('%03d', fake()->unique()->numberBetween(1, 500)),
            'floor' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['available', 'available', 'available', 'occupied', 'maintenance']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'occupied',
        ]);
    }
}
