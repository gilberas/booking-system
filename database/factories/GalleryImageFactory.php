<?php

namespace Database\Factories;

use App\Models\GalleryImage;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    public function definition(): array
    {
        return [
            'imageable_type' => Hotel::class,
            'imageable_id' => Hotel::factory(),
            'url' => 'https://picsum.photos/seed/'.fake()->uuid().'/800/600',
            'alt_text' => fake()->words(4, true),
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    }
}
