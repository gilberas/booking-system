<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<RoomType>
 */
class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;

    private static array $typeTemplates = [
        ['name' => 'Standard Room', 'beds' => 1, 'bed_type' => 'twin', 'occupancy' => 2, 'price' => 99],
        ['name' => 'Deluxe Room', 'beds' => 1, 'bed_type' => 'queen', 'occupancy' => 2, 'price' => 149],
        ['name' => 'Executive Room', 'beds' => 1, 'bed_type' => 'king', 'occupancy' => 2, 'price' => 199],
        ['name' => 'Suite', 'beds' => 2, 'bed_type' => 'king', 'occupancy' => 4, 'price' => 299],
        ['name' => 'Presidential Suite', 'beds' => 3, 'bed_type' => 'king', 'occupancy' => 6, 'price' => 599],
    ];

    public function definition(): array
    {
        $template = fake()->randomElement(self::$typeTemplates);

        return [
            'hotel_id' => Hotel::factory(),
            'name' => $template['name'],
            'slug' => fn (array $attrs) => Str::slug($attrs['name'].'-'.Hotel::find($attrs['hotel_id'])->slug),
            'description' => fake()->paragraphs(2, true),
            'max_occupancy' => $template['occupancy'],
            'num_beds' => $template['beds'],
            'bed_type' => $template['bed_type'],
            'base_price' => $template['price'],
            'size_sqft' => fake()->numberBetween(250, 1200),
            'num_rooms_total' => fake()->numberBetween(5, 30),
            'is_smoking' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}
