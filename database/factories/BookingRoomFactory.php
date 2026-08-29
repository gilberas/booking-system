<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingRoom>
 */
class BookingRoomFactory extends Factory
{
    protected $model = BookingRoom::class;

    public function definition(): array
    {
        $pricePerNight = fake()->randomFloat(2, 80, 500);
        $nights = fake()->numberBetween(1, 7);

        return [
            'booking_id' => Booking::factory(),
            'room_id' => Room::factory(),
            'room_type_id' => fn (array $attrs) => Room::find($attrs['room_id'])->room_type_id,
            'check_in' => fn (array $attrs) => Booking::find($attrs['booking_id'])->check_in,
            'check_out' => fn (array $attrs) => Booking::find($attrs['booking_id'])->check_out,
            'adults' => fake()->numberBetween(1, 2),
            'children' => fake()->numberBetween(0, 2),
            'price_per_night' => $pricePerNight,
            'total_price' => $pricePerNight * $nights,
            'extra_bed' => fake()->boolean(20),
            'extra_bed_charge' => fn (array $attrs) => $attrs['extra_bed'] ? fake()->randomFloat(2, 20, 50) : 0,
            'status' => fn (array $attrs) => Booking::find($attrs['booking_id'])->status,
        ];
    }
}
