<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds=User::pluck('id')->toArray();
        return [
            'user_id' => rand($userIds[0], end($userIds)),
            'title' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => 'approved',
        ];
    }
}
