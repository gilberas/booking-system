<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Amenity\StoreAmenityRequest;
use App\Http\Requests\Amenity\UpdateAmenityRequest;
use App\Models\Amenity;
use App\Services\Hotel\AmenityService;

class AmenityController extends Controller
{
    public function __construct(
        private readonly AmenityService $amenityService
    ) {}

    public function index()
    {
        $amenities = $this->amenityService->paginate();

        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(StoreAmenityRequest $request)
    {
        $this->amenityService->create($request->validated());

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created successfully.');
    }

    public function show(Amenity $amenity)
    {
        return view('admin.amenities.show', compact('amenity'));
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, Amenity $amenity)
    {
        $this->amenityService->update($amenity, $request->validated());

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $this->amenityService->delete($amenity);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}
