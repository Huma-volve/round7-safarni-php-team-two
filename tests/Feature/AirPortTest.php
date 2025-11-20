<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Airport;

class AirPortTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_get_list_of_airports()
    {
        Airport::factory()->count(3)->create();

        $response = $this->getJson('/api/airports');

        // 3. التأكيد:
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                // التأكيد على هيكل الرد الموحد (Trait)
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'airport_name', // من الـ Resource
                        'code',
                        'city_location' // من الـ Resource
                    ]
                ]
            ]);
    }

    /** @test */
    public function test_can_store_new_airport()
    {
        // 1. التجهيز: بيانات المطار الجديد
        $airportData = [
            'name' => 'Giza Sphinx Airport',
            'code' => 'SPX',
            'city' => 'Giza',
            'location' => 'Egypt',
        ];

        // 2. الفعل: إرسال بيانات الإضافة (POST) مباشرة
        $response = $this->postJson('/api/airports', $airportData);

        // 3. التأكيد:
        $response->assertStatus(201) // 201 Created
        ->assertJsonPath('data.code', 'SPX'); // نتاكد إن الرد فيه الداتا

        // نتاكد إن الـ Validation نجح وإن الداتا وصلت الداتا بيز
        $this->assertDatabaseHas('airports', [
            'code' => 'SPX',
            'name' => 'Giza Sphinx Airport'
        ]);
    }

    /** @test */
    public function test_cannot_store_airport_with_missing_required_fields()
    {
        // نرسل بيانات ناقصة (بدون code)
        $response = $this->postJson('/api/airports', [
            'name' => 'Missing Code Airport',
            'city' => 'Test City',
            // 'code' is missing here
        ]);

        // نتأكد إن الـ Validation فشل (422 Unprocessable Entity)
        $response->assertStatus(422);

        // نتأكد إن الرسالة بتاعة الخطأ ظهرت للـ 'code'
        $response->assertJsonValidationErrors('code');

        // نتأكد إن المطار ده مضافش للداتا بيز
        $this->assertDatabaseMissing('airports', ['name' => 'Missing Code Airport']);
    }
}
