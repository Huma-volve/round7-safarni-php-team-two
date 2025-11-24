<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Car;
use App\Models\Tour;
use App\Models\Review;
use Faker\Factory as Faker;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 🎯 Seed reviews for hotels
        foreach (Hotel::all() as $hotel) {
            Review::factory()->count(rand(3, 7))->create([
                'reviewable_id' => $hotel->id,
                'reviewable_type' => Hotel::class,
            ]);
        }

        // 🎯 Seed reviews for cars
        foreach (Car::all() as $car) {
            Review::factory()->count(rand(3, 7))->create([
                'reviewable_id' => $car->id,
                'reviewable_type' => Car::class,
            ]);
        }

        // 🎯 Seed reviews for tours
        foreach (Tour::all() as $tour) {
            Review::factory()->count(rand(3, 7))->create([
                'reviewable_id' => $tour->id,
                'reviewable_type' => Tour::class,
            ]);
        }
    }
}
