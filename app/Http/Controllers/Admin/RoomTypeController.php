<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Services\Hotel\RoomTypeService;

class RoomTypeController extends Controller
{
    public function __construct(
        private readonly RoomTypeService $roomTypeService
    ) {}

    public function index(Hotel $hotel)
    {
        $roomTypes = $this->roomTypeService->paginateByHotel($hotel);

        return view('admin.room-types.index', compact('hotel', 'roomTypes'));
    }

    public function create(Hotel $hotel)
    {
        return view('admin.room-types.create', compact('hotel'));
    }

    public function store(StoreRoomTypeRequest $request, Hotel $hotel)
    {
        $this->roomTypeService->create($hotel, $request->validated());

        return redirect()->route('admin.hotels.room-types.index', $hotel)
            ->with('success', 'Room type created successfully.');
    }

    public function show(Hotel $hotel, RoomType $roomType)
    {
        $roomType->load('rooms', 'amenities');

        return view('admin.room-types.show', compact('hotel', 'roomType'));
    }

    public function edit(Hotel $hotel, RoomType $roomType)
    {
        return view('admin.room-types.edit', compact('hotel', 'roomType'));
    }

    public function update(UpdateRoomTypeRequest $request, Hotel $hotel, RoomType $roomType)
    {
        $this->roomTypeService->update($roomType, $request->validated());

        return redirect()->route('admin.hotels.room-types.index', $hotel)
            ->with('success', 'Room type updated successfully.');
    }

    public function destroy(Hotel $hotel, RoomType $roomType)
    {
        $this->roomTypeService->delete($roomType);

        return redirect()->route('admin.hotels.room-types.index', $hotel)
            ->with('success', 'Room type deleted successfully.');
    }
}
