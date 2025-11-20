<?php

namespace App\Http\Requests;

use App\Enums\FlightStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFlightRequest extends FormRequest
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
            'carrier_id' => 'required|exists:carriers,id',
            'origin_airport_id' => 'required|exists:airports,id',
            'dest_airport_id' => 'required|exists:airports,id|different:origin_airport_id', // التأكد من اختلاف مطار الوصول عن المغادرة

            // بيانات الرحلة
            'flight_number' => 'required|string|unique:flights,flight_number|max:10', // يجب أن يكون رقم الرحلة فريداً

            // التواريخ والأوقات
            'departure_at' => 'required|date_format:Y-m-d H:i:s|after:now', // يجب أن يكون تاريخ المغادرة مستقبلياً
            'arrival_at' => 'required|date_format:Y-m-d H:i:s|after:departure_at', // يجب أن يكون تاريخ الوصول بعد المغادرة

            // حالة الرحلة (باستخدام الـ Enum الذي أنشأناه)
            'status' => ['nullable', new Enum(FlightStatus::class)],

            // المدة (قد يتم حسابها تلقائياً، لكن يمكن إرسالها)

        ];
    }
}
