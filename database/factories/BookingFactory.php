<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('now', '+30 days');
        $checkOut = (clone $checkIn)->modify('+'.fake()->numberBetween(1, 7).' days');
        $adults = fake()->numberBetween(1, 3);
        $children = fake()->numberBetween(0, 2);
        $subtotal = fake()->randomFloat(2, 200, 2000);
        $taxRate = 0.10;
        $tax = round($subtotal * $taxRate, 2);

        return [
            'booking_number' => 'BK-'.strtoupper(Str::random(10)),
            'user_id' => User::factory(),
            'hotel_id' => Hotel::factory(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled']),
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'num_guests' => $adults + $children,
            'adults' => $adults,
            'children' => $children,
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'total_amount' => $subtotal + $tax,
            'paid_amount' => 0,
            'currency' => 'USD',
            'booking_source' => fake()->randomElement(['web', 'walk-in', 'phone', 'agent']),
            'special_requests' => fake()->optional(0.3)->sentence(),
            'guest_notes' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }
}
