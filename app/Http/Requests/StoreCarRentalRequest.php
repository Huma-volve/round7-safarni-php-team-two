<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRentalRequest extends FormRequest
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
            // Location
            'pickup_location'   => 'required|string|max:255',
            'dropoff_location'  => 'nullable|string|max:255',
            'pickup_lat'        => 'nullable|numeric|between:-90,90',
            'pickup_lng'        => 'nullable|numeric|between:-180,180',
            'dropoff_lat'       => 'nullable|numeric|between:-90,90',
            'dropoff_lng'       => 'nullable|numeric|between:-180,180',

            // Time
            'pickup_time'    => 'required|date|after_or_equal:now',
            'dropoff_time'   => 'required|date|after:pickup_time',

            // Pricing
            'price_per_hour' => 'nullable|numeric|min:0',
            'total_price'    => 'nullable|numeric|min:0',

            // Plan
            'plan_type'      => 'required|in:hourly,daily',
            'duration_hours' => 'nullable|integer|min:1|required_if:plan_type,hourly',
            'duration_days'  => 'nullable|integer|min:1|required_if:plan_type,daily',

            // Status
            'status'          => 'nullable|in:pending,confirmed,in_progress,completed,canceled',
            'payment_status'  => 'nullable|in:pending,paid,canceled,refunded',
            'payment_method'  => 'nullable|in:paypal,mastercard,visa,cash,stripe',

            // Transaction
            'transaction_id'  => 'nullable|string|max:255',
        ];
    }
}
