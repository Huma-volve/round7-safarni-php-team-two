<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'hotel_id' => Hotel::factory(), 
            'name' => $this->faker->word . ' Room',
            'description' => $this->faker->paragraph,
            'photos' => json_encode([
                $this->faker->imageUrl(800,600,'nightlife'),
                $this->faker->imageUrl(800,600,'nightlife')
            ]),
            'main_image' => $this->faker->imageUrl(800, 600, 'city'),

            'occupancy' => json_encode([
                'adults' => $this->faker->numberBetween(1,3),
                'children' => $this->faker->numberBetween(0,2),
                'infants' => $this->faker->numberBetween(0,1),
            ]),
            'bed_type' => $this->faker->randomElement(['single','double','queen','king']),
            'room_area' => $this->faker->numberBetween(20,50),
            'price_per_night' => $this->faker->randomFloat(2,50,500),
            'seasonal_pricing' => json_encode([
                '2025-06' => $this->faker->randomFloat(2,50,500),
                '2025-07' => $this->faker->randomFloat(2,50,500)
            ]),
            'availability_calendar' => json_encode([
                '2025-06-10' => true,
                '2025-06-11' => false
            ]),
            'refundable' => $this->faker->boolean,
            'extras' => json_encode(['breakfast','airport_pickup']),
        ];
    }
}
