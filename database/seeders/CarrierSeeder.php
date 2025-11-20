<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. إنشاء 10 شركات طيران وهمية
        Carrier::factory()->count(10)->create();

        // 2. إدخال شركات طيران حقيقية
        Carrier::firstOrCreate(['code' => 'MS'], [
            'name' => 'EgyptAir',
            'logo_url' => 'https://example.com/logos/egyptair.png',
        ]);

        Carrier::firstOrCreate(['code' => 'EK'], [
            'name' => 'Emirates',
            'logo_url' => 'https://example.com/logos/emirates.png',
        ]);

        Carrier::firstOrCreate(['code' => 'QR'], [
            'name' => 'Qatar Airways',
            'logo_url' => 'https://example.com/logos/qatar.png',
        ]);
    }
}
