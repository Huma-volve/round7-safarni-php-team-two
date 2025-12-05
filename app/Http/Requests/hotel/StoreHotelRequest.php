<?php

namespace App\Http\Requests\hotel;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
    'slug' => 'nullable|string|max:255|unique:hotels,slug',
    'description' => 'nullable|string',
    'address' => 'required|string|max:500',
    'hotel_image' => 'nullable|image',
    'amenities' => 'nullable|array',
    'amenities.*' => 'string|max:255',
    'policies' => 'nullable|array',
    'policies.*' => 'string|max:500',
    'contact_info' => 'nullable|array',
    'contact_info.phone' => 'nullable|string|max:20',
    'contact_info.email' => 'nullable|email|max:255',
    'location' => 'required|array',
    'location.lat' => 'required|numeric|between:-90,90',
    'location.lng' => 'required|numeric|between:-180,180',
];

}

}
