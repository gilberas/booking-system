<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'title', 'content', 'type', 'group', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
