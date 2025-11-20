<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrier>
 */
class CarrierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company . ' Airlines';
        return [
            'name' => $name,
            // كود الشركة (حرفين كابيتال عشوائية)
            'code' => strtoupper($this->faker->unique()->lexify('??')),
            // رابط وهمي للوجو
            'logo_url' => $this->faker->imageUrl(60, 60, 'transport'),
        ];
    }
}
