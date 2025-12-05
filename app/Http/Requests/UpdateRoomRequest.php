<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
    'name' => 'sometimes|string|max:255',
    'description' => 'sometimes|string',
    'photos' => 'sometimes|array',
    'photos.*' => 'file|image|mimes:jpg,jpeg,png,gif|max:5120', // ملف صورة max 5MB
    'main_image' => 'sometimes|file|image|mimes:jpg,jpeg,png,gif|max:5120',
    'bed_number' => 'nullable|integer',
    'room_area' => 'sometimes|numeric|min:0',
    'price_per_night' => 'sometimes|numeric|min:0',
    'availability_calendar' => 'sometimes',
];

    }
}
