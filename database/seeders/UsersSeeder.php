<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // إنشاء الدور admin و user لو مش موجودين
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // إنشاء مستخدم admin ثابت
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // لو موجود ما ينشأش تاني
            [
                'name' => 'Admin User',
                'phone' => '01155991725',
                'address' => 'Cairo, Egypt',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($adminRole);

        // إنشاء 19 مستخدم عادي
        for ($i = 1; $i <= 19; $i++) {
            $user = User::firstOrCreate(
                ['email' => $faker->unique()->safeEmail],
                [
                    'name' => $faker->name,
                    'password' => Hash::make('password123'),
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                ]
            );
            $user->assignRole($userRole);
        }
    }
}
