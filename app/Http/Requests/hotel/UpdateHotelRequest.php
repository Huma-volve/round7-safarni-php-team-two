<?php

namespace App\Http\Requests\hotel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
        'slug' => 'sometimes|string|max:255|unique:hotels,slug,' . $this->hotel->id,
        'description' => 'sometimes|string',
        'address' => 'sometimes|string|max:500',
        'image' => 'sometimes|url',
      'amenities' => 'nullable',
'amenities.*' => 'string|max:255',
'policies' => 'nullable',
'policies.*' => 'string|max:500',
        'contact_info' => 'sometimes|array',
        'contact_info.phone' => 'sometimes|string|max:20',
        'contact_info.email' => 'sometimes|email|max:255',
        'location' => 'sometimes|array',
        'location.lat' => 'sometimes|numeric|between:-90,90',
        'location.lng' => 'sometimes|numeric|between:-180,180',
    ];
}


}
