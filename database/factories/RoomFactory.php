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
       $availableDaysCount = $this->faker->numberBetween(7, 14);
     $availability = [];

for ($i = 0; $i < $availableDaysCount; $i++) {
    $date = now()->addDays($i)->toDateString();
    $availability[] = $date; // نضيف التاريخ
}

return [
    'hotel_id' => Hotel::factory(),
    'name' => $this->faker->word(),
    'description' => $this->faker->sentence(),
    // 'photos' => [$this->faker->imageUrl(), $this->faker->imageUrl()],
    // 'main_image' => $this->faker->imageUrl(),
    'bed_number' => $this->faker->numberBetween(2, 15),
    'room_area' => $this->faker->numberBetween(20, 60),
    'price_per_night' => $this->faker->randomFloat(2, 100, 500),
    'availability_calendar' => $availability, // Array مش JSON
];

    }
}
