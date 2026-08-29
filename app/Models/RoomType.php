<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'name', 'slug', 'description', 'max_occupancy', 'num_beds',
        'bed_type', 'base_price', 'rating', 'size_sqft', 'num_rooms_total',
        'is_smoking', 'is_active',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'base_price' => 'decimal:2',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(GalleryImage::class, 'imageable');
    }
}
