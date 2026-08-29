<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'user_id' => User::factory(),
            'invoice_id' => null,
            'payment_method' => fake()->randomElement(['cash', 'card', 'bank_transfer', 'online']),
            'transaction_id' => fn (array $attrs) => $attrs['payment_method'] === 'cash' ? null : 'TXN-'.fake()->uuid(),
            'amount' => fake()->randomFloat(2, 100, 1000),
            'currency' => 'USD',
            'status' => fake()->randomElement(['pending', 'completed', 'completed', 'failed', 'refunded']),
            'paid_at' => fn (array $attrs) => $attrs['status'] === 'completed' ? now() : null,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }
}
