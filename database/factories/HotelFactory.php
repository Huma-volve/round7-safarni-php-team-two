<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public $name;
    public function definition(): array
    {

     $name    = $this->faker->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 1000),
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image' => $this->faker->imageUrl(800, 600, 'city'),
            'amenities' => json_encode(['wifi','parking','pool']),
            'rating' => $this->faker->randomFloat(2, 3, 5),
            'policies' => json_encode([
                'check_in' => '14:00',
                'check_out' => '12:00',
                'cancellation' => 'Free cancellation within 24h'
            ]),
            'contact_info' => json_encode([
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->companyEmail
            ]),
        ];
    }
}
