<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => ['required', 'string', 'max:20', Rule::unique('rooms', 'room_number')->ignore($this->room)->where(function ($q) {
                return $q->where('hotel_id', $this->hotel_id);
            })],
            'floor' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:available,occupied,maintenance,cleaning'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
