<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'WiFi', 'icon' => 'wifi', 'category' => 'entertainment', 'image' => 'images/amenities/wifi.svg'],
            ['name' => 'Air Conditioner', 'icon' => 'snowflake', 'category' => 'bathroom', 'image' => 'images/amenities/air-conditioner.png'],
            ['name' => 'Television', 'icon' => 'tv', 'category' => 'entertainment', 'image' => 'images/amenities/television.png'],
            ['name' => 'Mini Bar', 'icon' => 'glass', 'category' => 'food', 'image' => 'images/amenities/mini-bar.png'],
            ['name' => 'Parking', 'icon' => 'car', 'category' => 'business', 'image' => 'images/amenities/parking.png'],
            ['name' => 'Breakfast', 'icon' => 'coffee', 'category' => 'food', 'image' => 'images/amenities/breakfast.png'],
            ['name' => 'Swimming Pool', 'icon' => 'pool', 'category' => 'entertainment', 'image' => 'images/amenities/swimming-pool.png'],
            ['name' => 'Gym', 'icon' => 'dumbbell', 'category' => 'entertainment', 'image' => 'images/amenities/gym.svg'],
            ['name' => 'Laundry', 'icon' => 'shirt', 'category' => 'business', 'image' => 'images/amenities/laundry.svg'],
            ['name' => 'Balcony', 'icon' => 'tree', 'category' => 'bathroom', 'image' => 'images/amenities/balcony.svg'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(
                ['slug' => Str::slug($amenity['name'])],
                [
                    'name' => $amenity['name'],
                    'icon' => $amenity['icon'],
                    'category' => $amenity['category'],
                    'description' => $amenity['name'].' available in this room.',
                    'image' => $amenity['image'],
                ]
            );
        }
    }
}
