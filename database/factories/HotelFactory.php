<?php
namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        $name = $this->faker->company;
        $lat = $this->faker->latitude;
        $lng = $this->faker->longitude;

        return [
            'name' => $name,
            // بديل الـ unique عشان ما يحصل overflow
            'slug' => Str::slug($name) . '-' . $this->faker->randomNumber(5, true),
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'latitude' => $lat,
            'longitude' => $lng,
            'image' => $this->faker->imageUrl(800, 600, 'city'),
            'amenities' => json_encode(['wifi','parking','pool']),
            'rating' => $this->faker->randomFloat(2, 3, 5),
            'category_id'=>Category::where('name','hotels')->first()->id,
            'policies' => json_encode([
                'check_in' => '14:00',
                'check_out' => '12:00',
                'cancellation' => 'Free cancellation within 24h'
            ]),
            'contact_info' => json_encode([
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->companyEmail
            ]),
            'location' => DB::raw("ST_PointFromText('POINT($lat $lng)')"),
        ];
    }

    // بعد الإنشاء مباشرة، نحدث عمود location
    /*public function configure()
    {
        return $this->afterCreating(function (Hotel $hotel) {
            $lat = $hotel->latitude;
            $lng = $hotel->longitude;
            $hotel->update([
                'location' => DB::raw("POINT($lat, $lng)")
            ]);
        });
    }*/
}




