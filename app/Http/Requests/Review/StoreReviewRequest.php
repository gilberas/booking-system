<?php

namespace App\Http\Requests\Review;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        $booking = Booking::findOrFail($this->route('booking'));

        return $booking->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $booking = Booking::findOrFail($this->route('booking'));

            if ($booking->status !== 'checked_out') {
                $validator->errors()->add('booking', 'You can only review a booking after checkout.');
            }

            if ($booking->review()->exists()) {
                $validator->errors()->add('booking', 'You have already reviewed this booking.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Please select a rating.',
            'body.required' => 'Please write your review.',
            'body.min' => 'Your review must be at least 20 characters.',
        ];
    }
}
