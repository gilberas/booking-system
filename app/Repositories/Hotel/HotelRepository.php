<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HotelRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Hotel::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Hotel
    {
        return Hotel::find($id);
    }

    public function findBySlug(string $slug): ?Hotel
    {
        return Hotel::where('slug', $slug)->first();
    }

    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function update(Hotel $hotel, array $data): bool
    {
        return $hotel->update($data);
    }

    public function delete(Hotel $hotel): bool
    {
        return $hotel->delete();
    }

    public function all(): Collection
    {
        return Hotel::where('is_active', true)->orderBy('name')->get();
    }
}
