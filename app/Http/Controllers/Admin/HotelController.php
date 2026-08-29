<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Models\Hotel;
use App\Services\Hotel\HotelService;

class HotelController extends Controller
{
    public function __construct(
        private readonly HotelService $hotelService
    ) {}

    public function index()
    {
        $hotels = $this->hotelService->paginate();

        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(StoreHotelRequest $request)
    {
        $this->hotelService->create($request->validated());

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load('roomTypes');

        return view('admin.hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $this->hotelService->update($hotel, $request->validated());

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $this->hotelService->delete($hotel);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
