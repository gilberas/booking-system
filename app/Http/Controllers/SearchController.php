<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService
    ) {}

    public function index(Request $request)
    {
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();
        $roomTypes = RoomType::with('amenities')->where('is_active', true)->get();
        $amenities = Amenity::orderBy('name')->get();

        $results = null;
        $selectedHotel = null;

        if ($request->filled('check_in') && $request->filled('check_out') && $request->filled('guests')) {
            $validated = $request->validate([
                'check_in' => ['required', 'date', 'after_or_equal:today'],
                'check_out' => ['required', 'date', 'after:check_in'],
                'guests' => ['required', 'integer', 'min:1', 'max:50'],
                'hotel_id' => ['nullable', 'exists:hotels,id'],
                'min_price' => ['nullable', 'numeric', 'min:0'],
                'max_price' => ['nullable', 'numeric', 'min:0'],
                'amenities' => ['nullable', 'array'],
                'amenities.*' => ['exists:amenities,id'],
            ]);

            $hotelId = $request->input('hotel_id') ?: $hotels->first()?->id;
            if ($hotelId) {
                $selectedHotel = Hotel::find($hotelId);
                $results = $this->bookingService->getAvailableRoomTypes(
                    $hotelId,
                    $request->input('check_in'),
                    $request->input('check_out'),
                    (int) $request->input('guests'),
                );

                $minPrice = $request->input('min_price');
                $maxPrice = $request->input('max_price');
                $amenityIds = $request->input('amenities', []);

                if ($minPrice || $maxPrice) {
                    $results = $results->filter(function ($rt) use ($minPrice, $maxPrice) {
                        if ($minPrice && $rt->base_price < $minPrice) {
                            return false;
                        }
                        if ($maxPrice && $rt->base_price > $maxPrice) {
                            return false;
                        }

                        return true;
                    })->values();
                }

                if (! empty($amenityIds)) {
                    $results = $results->filter(function ($rt) use ($amenityIds) {
                        $rtAmenityIds = $rt->amenities->pluck('id')->toArray();

                        return empty(array_diff($amenityIds, $rtAmenityIds));
                    })->values();
                }
            }
        }

        return view('search.index', compact(
            'hotels', 'roomTypes', 'amenities', 'results', 'selectedHotel'
        ));
    }

    public function hotel(Hotel $hotel)
    {
        abort_if(! $hotel->is_active, 404);
        $hotel->load(['roomTypes' => fn ($q) => $q->where('is_active', true)->with('amenities')]);

        return view('search.hotel', compact('hotel'));
    }

    public function roomType(Hotel $hotel, RoomType $roomType)
    {
        abort_if(! $hotel->is_active || ! $roomType->is_active, 404);
        $roomType->load('amenities');

        return view('search.room-type', compact('hotel', 'roomType'));
    }
}
