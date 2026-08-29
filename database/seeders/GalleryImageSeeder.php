<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $hotelImages = [
            'amalfi-crest' => 'https://images.unsplash.com/photo-1742844552700-3926862c5311?w=800&h=700&fit=crop&auto=format',
            'obsidian-peaks' => 'https://images.unsplash.com/photo-1615676893771-94c4d0a2f1ca?w=800&h=700&fit=crop&auto=format',
            'velour-skyline' => 'https://images.unsplash.com/photo-1688933758128-83d40ab10b4e?w=800&h=700&fit=crop&auto=format',
            'cerulean-isle' => 'https://images.unsplash.com/photo-1721617864119-611e4544ff07?w=800&h=700&fit=crop&auto=format',
            'palomar-grand' => 'https://images.unsplash.com/photo-1646991761123-d83ce47c30c9?w=800&h=700&fit=crop&auto=format',
            'kaia-cove' => 'https://images.unsplash.com/photo-1725006136539-46bef885df06?w=800&h=700&fit=crop&auto=format',
        ];

        $roomImages = [
            'sea-view-room' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&h=400&fit=crop&auto=format',
            'cliffside-suite' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&h=400&fit=crop&auto=format',
            'amalfi-penthouse' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&h=400&fit=crop&auto=format',
            'alpine-room' => 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=600&h=400&fit=crop&auto=format',
            'summit-suite' => 'https://images.unsplash.com/photo-1564078516393-cf04bd966897?w=600&h=400&fit=crop&auto=format',
            'grand-chalet' => 'https://images.unsplash.com/photo-1470770841497-7b3208bbb6c2?w=600&h=400&fit=crop&auto=format',
            'city-view-room' => 'https://images.unsplash.com/photo-1590490359854-dfba85636e24?w=600&h=400&fit=crop&auto=format',
            'sky-penthouse' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&h=400&fit=crop&auto=format',
            'overwater-villa' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=600&h=400&fit=crop&auto=format',
            'reef-residence' => 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?w=600&h=400&fit=crop&auto=format',
            'heritage-room' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=600&h=400&fit=crop&auto=format',
            'palace-suite' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=600&h=400&fit=crop&auto=format',
            'garden-pavilion' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=600&h=400&fit=crop&auto=format',
            'beachfront-villa' => 'https://images.unsplash.com/photo-1499793983394-e58fc2fce945?w=600&h=400&fit=crop&auto=format',
            'cove-residence' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&h=400&fit=crop&auto=format',
        ];

        foreach ($hotelImages as $slug => $url) {
            $hotel = Hotel::where('slug', $slug)->first();
            if (! $hotel) {
                continue;
            }
            GalleryImage::firstOrCreate(
                [
                    'imageable_type' => Hotel::class,
                    'imageable_id' => $hotel->id,
                    'url' => $url,
                ],
                [
                    'alt_text' => $hotel->name,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]
            );
        }

        $roomTypes = RoomType::with('hotel')->get();
        foreach ($roomTypes as $roomType) {
            $url = $roomImages[$roomType->slug] ?? 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&h=400&fit=crop&auto=format';
            GalleryImage::firstOrCreate(
                [
                    'imageable_type' => RoomType::class,
                    'imageable_id' => $roomType->id,
                    'url' => $url,
                ],
                [
                    'alt_text' => $roomType->name,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]
            );
        }
    }
}
