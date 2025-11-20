<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\FlightStatus;
use Illuminate\Validation\Rules\Enum;

class UpdateFlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $flightId = $this->route('flight')->id;

        return [
            'carrier_id' => ['sometimes', 'exists:carriers,id'],
            'origin_airport_id' => ['sometimes', 'exists:airports,id'],

            'flight_number' => [
                'sometimes',
                'string',
                'max:10',
                Rule::unique('flights', 'flight_number')->ignore($flightId),
            ],

            'dest_airport_id' => [
                'sometimes',
                'exists:airports,id',
                Rule::prohibits('dest_airport_id')->where(fn ($query) => $query->where('origin_airport_id', $this->origin_airport_id)),
            ],

            'departure_at' => [
                'sometimes',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:now'
            ],
            'arrival_at' => [
                'sometimes',
                'date_format:Y-m-d H:i:s',
                'after:departure_at'
            ],

            'status' => ['sometimes', new Enum(FlightStatus::class)],

            'duration' => ['nullable', 'string', 'max:50'],

            'economy_seats' => ['nullable', 'integer', 'min:0'],
            'business_seats' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
