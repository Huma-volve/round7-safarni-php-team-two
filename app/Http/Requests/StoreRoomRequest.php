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
        'photos' => 'nullable',
        'photos.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max
        'main_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        'bed_number' => 'nullable|integer',
        'room_area' => 'nullable|numeric|min:0',
        'price_per_night' => 'required|numeric|min:0',
        'availability_calendar' => 'nullable|array',
    ];
}

}
