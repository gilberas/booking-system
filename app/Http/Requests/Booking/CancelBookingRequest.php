<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CancelBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cancellation_reason' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'cancellation_reason.required' => 'Please provide a reason for cancellation.',
            'cancellation_reason.min' => 'Please provide at least 10 characters explaining the reason.',
        ];
    }
}
