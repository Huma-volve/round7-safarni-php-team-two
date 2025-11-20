<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'reviewable_type' => 'required|string|in:hotel,room,tour',
            'reviewable_id'   => 'required|integer',
            'rating'          => 'required|integer|min:1|max:5',
            'title'           => 'nullable|string|max:255',
            'body'            => 'required|string',
            'photos'          => 'nullable|array',
            'photos.*'        => 'url', // أو base64 حسب الـ Frontend
        ];
    }
}
