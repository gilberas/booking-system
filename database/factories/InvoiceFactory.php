<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 200, 3000);
        $taxPercentage = 10.00;
        $tax = round($subtotal * ($taxPercentage / 100), 2);

        return [
            'booking_id' => Booking::factory(),
            'invoice_number' => 'INV-'.strtoupper(Str::random(10)),
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'subtotal' => $subtotal,
            'tax_percentage' => $taxPercentage,
            'tax_amount' => $tax,
            'total' => $subtotal + $tax,
            'status' => fake()->randomElement(['draft', 'sent', 'paid', 'overdue']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
