<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Airport; // عشان نجيب مطارات عشوائية
use App\Models\Carrier; // عشان نجيب شركات طيران عشوائية
use App\Enums\FlightStatus; // عشان نستخدم الـ Enum اللي عملناه
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        // 1. تحديد مواعيد الرحلة (الذهاب والوصول)
        $departureTime = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $arrivalTime = (clone $departureTime)->modify('+' . $this->faker->numberBetween(1, 10) . ' hours');

        // 2. الحصول على IDs عشوائية للمطارات وشركات الطيران
        $airportIds = Airport::pluck('id');
        $carrierId = Carrier::inRandomOrder()->first()->id;

        // نختار مطار المغادرة (Origin)
        $originAirportId = $this->faker->randomElement($airportIds);

        // نختار مطار الوصول (Destination) ونتأكد إنه مختلف عن المغادرة
        $destinationAirportId = $this->faker->randomElement($airportIds->reject($originAirportId));

        return [
            // حقول العلاقات (Foreign Keys)
            'carrier_id' => $carrierId,
            'origin_airport_id' => $originAirportId,
            'dest_airport_id' => $destinationAirportId,

            // بيانات الرحلة
            'flight_number' => $this->faker->unique()->numberBetween(100, 9999),

            // استخدام الـ Enum لحالة الرحلة (بترجع القيمة الرقمية 0, 1, 2)
            'status' => $this->faker->randomElement(FlightStatus::cases())->value,

            // مواعيد الرحلة
            'departure_at' => $departureTime,
            'arrival_at' => $arrivalTime,

            // حساب المدة (Duration) ممكن يكون String يوضح المدة، أو يتم حسابه لاحقاً
            'duration' => $departureTime->diff($arrivalTime)->format('%h hours %i minutes'),
        ];
    }
}
