<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'booking_id' => 'required|integer|exists:bookings,id',
        ];
    }

    public function messages()
    {
        return [
            'booking_id.required' => 'Booking ID مطلوب.',
            'booking_id.integer' => 'Booking ID لازم يكون رقم.',
            'booking_id.exists' => 'Booking ID غير موجود في النظام.',
        ];
    }
}
