<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Hotel\RoomService;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomService $roomService
    ) {}

    public function index(Hotel $hotel, RoomType $roomType)
    {
        $rooms = $this->roomService->paginateByRoomType($roomType);

        return view('admin.rooms.index', compact('hotel', 'roomType', 'rooms'));
    }

    public function create(Hotel $hotel, RoomType $roomType)
    {
        return view('admin.rooms.create', compact('hotel', 'roomType'));
    }

    public function store(StoreRoomRequest $request, Hotel $hotel, RoomType $roomType)
    {
        $this->roomService->create($roomType, $request->validated());

        return redirect()->route('admin.hotels.room-types.rooms.index', [$hotel, $roomType])
            ->with('success', 'Room created successfully.');
    }

    public function show(Hotel $hotel, RoomType $roomType, Room $room)
    {
        return view('admin.rooms.show', compact('hotel', 'roomType', 'room'));
    }

    public function edit(Hotel $hotel, RoomType $roomType, Room $room)
    {
        return view('admin.rooms.edit', compact('hotel', 'roomType', 'room'));
    }

    public function update(UpdateRoomRequest $request, Hotel $hotel, RoomType $roomType, Room $room)
    {
        $this->roomService->update($room, $request->validated());

        return redirect()->route('admin.hotels.room-types.rooms.index', [$hotel, $roomType])
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Hotel $hotel, RoomType $roomType, Room $room)
    {
        $this->roomService->delete($room);

        return redirect()->route('admin.hotels.room-types.rooms.index', [$hotel, $roomType])
            ->with('success', 'Room deleted successfully.');
    }
}
