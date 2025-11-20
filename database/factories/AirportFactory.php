<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirportFactory extends Factory
{
    protected $model = Airport::class;

    public function definition(): array
    {
        // نستخدم مكتبة Faker عشان نعمل بيانات وهمية منطقية
        return [
            'name' => $this->faker->city . ' International Airport',
            // كود المطار (3 حروف كابيتال عشوائية)
            'code' => $this->faker->unique()->lexify('???'),
            'city' => $this->faker->city,
            'location' => $this->faker->country,
            // ممكن تضيف الـ Timezone هنا
            // 'timezone' => $this->faker->timezone,
        ];
    }
}
