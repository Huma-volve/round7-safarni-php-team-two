<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lat = $this->faker->latitude;
        $lng = $this->faker->longitude;

        return [
            'model' => $this->faker->word(),
            'price' => $this->faker->numberBetween(5000, 100000),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'image' => $this->faker->imageUrl(640, 480, 'cars', true),
            'category_id' =>Category::where('name', 'car_rentals')->first()->id,
            'location' => DB::raw("ST_PointFromText('POINT($lat $lng)')"),
        ];
    }
}
