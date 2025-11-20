<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airport;

class AirportSeeder extends Seeder
{
    /**
     * تشغيل بيانات المطارات.
     */
    public function run(): void
    {
        // 1. استخدام الـ Factory لإنشاء 30 مطار وهمي (لأغراض ملء الصفحة)
        Airport::factory()->count(30)->create();

        // 2. إدخال أهم المطارات الحقيقية يدوياً (التي لا غنى عنها في الاختبار)
        Airport::firstOrCreate(['code' => 'CAI'], [
            'name' => 'Cairo International Airport',
            'city' => 'Cairo',
            'location' => 'Egypt',
        ]);

        Airport::firstOrCreate(['code' => 'DXB'], [
            'name' => 'Dubai International Airport',
            'city' => 'Dubai',
            'location' => 'UAE',
        ]);

        // يمكنك إضافة أي مطارات حقيقية أخرى هنا
    }
}
