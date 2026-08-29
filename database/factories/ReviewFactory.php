<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'user_id' => fn (array $attrs) => Booking::find($attrs['booking_id'])->user_id,
            'hotel_id' => fn (array $attrs) => Booking::find($attrs['booking_id'])->hotel_id,
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->optional(0.7)->words(4, true),
            'body' => fake()->paragraphs(2, true),
            'is_approved' => fake()->boolean(60),
            'approved_by' => null,
            'approved_at' => null,
            'reply' => null,
            'replied_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }
}
