<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Airport;
use App\Models\Carrier;

class FlightSeeder extends Seeder
{
    /**
     * تشغيل بيانات الرحلات.
     */
    public function run(): void
    {
        // 💡 تحقق أولاً من وجود البيانات الأساسية
        if (Airport::count() === 0 || Carrier::count() === 0) {
            echo "يرجى تشغيل AirportSeeder و CarrierSeeder أولاً لضمان وجود المطارات وشركات الطيران.\n";
            return;
        }

        // 1. إنشاء 30 رحلة طيران وهمية
        // سنستخدم دالة create() على الـ Factory مباشرة
        Flight::factory()->count(30)->create();

        echo "تم إنشاء 30 رحلة طيران وهمية بنجاح.\n";
    }
}
