<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => ['required', 'string', 'max:20'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:available,occupied,maintenance,cleaning'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
