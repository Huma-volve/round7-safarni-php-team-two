<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


       $this->call([

        AirportSeeder::class,
        AdminSeeder::class,
        CategorySeeder::class,
        HotelSeeder::class,
        UsersSeeder::class,
        TourSeeder::class,
        CarSeeder::class,
        ReviewsSeeder::class,
       ]);
    }
}
