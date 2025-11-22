<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
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
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 5000),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'image' => $this->faker->imageUrl(640, 480, 'travel', true),
            'category_id' => Category::where('name', 'tours')->first()->id,
            'location' => DB::raw("ST_PointFromText('POINT($lat $lng)')"),
        ];
    }
}
