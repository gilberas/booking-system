<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $hotelRoomTypes = [
            'amalfi-crest' => [
                [
                    'name' => 'Sea View Room',
                    'slug' => 'sea-view-room',
                    'description' => 'Wake to sweeping Tyrrhenian Sea views from your private balcony. Italian marble floors, linen drapes, and a clawfoot tub define this coastal retreat.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 680,
                    'size_sqft' => 420,
                    'num_rooms_total' => 12,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Cliffside Suite',
                    'slug' => 'cliffside-suite',
                    'description' => 'A two-room suite perched on the cliff edge with panoramic sea views, private terrace, and butler service.',
                    'max_occupancy' => 3,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 1100,
                    'size_sqft' => 680,
                    'num_rooms_total' => 6,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Amalfi Penthouse',
                    'slug' => 'amalfi-penthouse',
                    'description' => 'The crown jewel — a rooftop penthouse with infinity plunge pool, 360° coastal panorama, and private chef kitchen.',
                    'max_occupancy' => 4,
                    'num_beds' => 2,
                    'bed_type' => 'king',
                    'base_price' => 2200,
                    'size_sqft' => 1400,
                    'num_rooms_total' => 2,
                    'is_smoking' => false,
                ],
            ],
            'obsidian-peaks' => [
                [
                    'name' => 'Alpine Room',
                    'slug' => 'alpine-room',
                    'description' => 'Warm timber walls and a stone fireplace frame views of the Matterhorn. Ski gear storage and heated floors come standard.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'queen',
                    'base_price' => 920,
                    'size_sqft' => 380,
                    'num_rooms_total' => 14,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Summit Suite',
                    'slug' => 'summit-suite',
                    'description' => 'A lofted suite with wraparound windows, private sauna, and direct ski-in access to the Matterhorn slopes.',
                    'max_occupancy' => 3,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 1500,
                    'size_sqft' => 620,
                    'num_rooms_total' => 8,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Grand Chalet',
                    'slug' => 'grand-chalet',
                    'description' => 'A standalone three-bedroom chalet with wine cellar, hot tub terrace, and private ski guide service.',
                    'max_occupancy' => 6,
                    'num_beds' => 3,
                    'bed_type' => 'king',
                    'base_price' => 3800,
                    'size_sqft' => 2200,
                    'num_rooms_total' => 3,
                    'is_smoking' => false,
                ],
            ],
            'velour-skyline' => [
                [
                    'name' => 'City View Room',
                    'slug' => 'city-view-room',
                    'description' => 'Floor-to-ceiling windows showcase Dubai\'s glittering skyline. Sleek furnishings, marble bath, and a work desk for the modern executive.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 1240,
                    'size_sqft' => 450,
                    'num_rooms_total' => 20,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Sky Penthouse',
                    'slug' => 'sky-penthouse',
                    'description' => 'Floor 72 luxury — private elevator, rooftop terrace with infinity pool, and 24-hour butler service above the clouds.',
                    'max_occupancy' => 4,
                    'num_beds' => 2,
                    'bed_type' => 'king',
                    'base_price' => 3500,
                    'size_sqft' => 1800,
                    'num_rooms_total' => 4,
                    'is_smoking' => false,
                ],
            ],
            'cerulean-isle' => [
                [
                    'name' => 'Overwater Villa',
                    'slug' => 'overwater-villa',
                    'description' => 'Glass-floor panels reveal the reef below. Step from your private deck into the turquoise lagoon of the Baa Atoll.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 1850,
                    'size_sqft' => 700,
                    'num_rooms_total' => 10,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Reef Residence',
                    'slug' => 'reef-residence',
                    'description' => 'A two-story water residence with underwater bedroom, private infinity pool, and direct reef snorkeling.',
                    'max_occupancy' => 4,
                    'num_beds' => 2,
                    'bed_type' => 'king',
                    'base_price' => 4200,
                    'size_sqft' => 2000,
                    'num_rooms_total' => 3,
                    'is_smoking' => false,
                ],
            ],
            'palomar-grand' => [
                [
                    'name' => 'Heritage Room',
                    'slug' => 'heritage-room',
                    'description' => 'Original 19th-century moldings meet contemporary Catalan design. Hand-painted tiles and wrought-iron balconies overlook Passeig de Gràcia.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'queen',
                    'base_price' => 560,
                    'size_sqft' => 350,
                    'num_rooms_total' => 18,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Palace Suite',
                    'slug' => 'palace-suite',
                    'description' => 'Once the merchant\'s private quarters — now a lavish suite with coffered ceilings, original chandeliers, and a private art gallery.',
                    'max_occupancy' => 3,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 1200,
                    'size_sqft' => 800,
                    'num_rooms_total' => 5,
                    'is_smoking' => false,
                ],
            ],
            'kaia-cove' => [
                [
                    'name' => 'Garden Pavilion',
                    'slug' => 'garden-pavilion',
                    'description' => 'Open-air living beneath tropical canopy. A stone garden bath, teak furnishings, and the sound of cascading water define this jungle escape.',
                    'max_occupancy' => 2,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 390,
                    'size_sqft' => 480,
                    'num_rooms_total' => 12,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Beachfront Villa',
                    'slug' => 'beachfront-villa',
                    'description' => 'Step from your terrace onto private sand. Indoor-outdoor living with a plunge pool, outdoor rain shower, and sunset views.',
                    'max_occupancy' => 3,
                    'num_beds' => 1,
                    'bed_type' => 'king',
                    'base_price' => 850,
                    'size_sqft' => 720,
                    'num_rooms_total' => 6,
                    'is_smoking' => false,
                ],
                [
                    'name' => 'Cove Residence',
                    'slug' => 'cove-residence',
                    'description' => 'The ultimate jungle villa — private beach access, infinity pool overlooking the Andaman Sea, and a personal wellness therapist.',
                    'max_occupancy' => 4,
                    'num_beds' => 2,
                    'bed_type' => 'king',
                    'base_price' => 1600,
                    'size_sqft' => 1500,
                    'num_rooms_total' => 2,
                    'is_smoking' => false,
                ],
            ],
        ];

        foreach ($hotelRoomTypes as $hotelSlug => $roomTypes) {
            $hotel = Hotel::where('slug', $hotelSlug)->first();
            if (! $hotel) {
                continue;
            }

            foreach ($roomTypes as $type) {
                RoomType::firstOrCreate(
                    ['hotel_id' => $hotel->id, 'slug' => $type['slug']],
                    array_merge($type, [
                        'hotel_id' => $hotel->id,
                    ])
                );
            }
        }
    }
}
