<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'max_occupancy' => ['required', 'integer', 'min:1', 'max:50'],
            'num_beds' => ['required', 'integer', 'min:1', 'max:10'],
            'bed_type' => ['required', 'string', 'max:50'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'size_sqft' => ['nullable', 'integer', 'min:1'],
            'num_rooms_total' => ['required', 'integer', 'min:1'],
            'is_smoking' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }
}
