<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'url',
            'main_image' => 'nullable|url',
            'occupancy' => 'nullable|array',
            'occupancy.adults' => 'nullable|integer|min:1',
            'occupancy.children' => 'nullable|integer|min:0',
            'bed_type' => 'nullable|string|max:100',
            'room_area' => 'nullable|numeric|min:0',
            'price_per_night' => 'required|numeric|min:0',
            'seasonal_pricing' => 'nullable|array',
            'availability_calendar' => 'nullable|array',
            'refundable' => 'nullable|boolean',
            'extras' => 'nullable|array',
            'extras.*' => 'string|max:255',
        ];
    }
}
