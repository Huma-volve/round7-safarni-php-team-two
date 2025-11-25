<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // إنشاء السوبر أدمن
    $admin = Admin::firstOrCreate([
        'name' => 'superadmin',
        'email' => 'superadmin@superadmin.com',
        'image' => 'user.png',
        'password' => bcrypt('123456'),
        'is_superadmin' => 1,
        'is_admin' => 0,
        'is_active' => 1,
    ]);

    // إنشاء دور السوبر أدمن
    $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admins']);

    // جلب جميع الصلاحيات
    $permissions = Permission::all();

    // تعيين جميع الصلاحيات لدور السوبر أدمن
    $role->syncPermissions($permissions);

    // تعيين دور السوبر أدمن للمستخدم
    $admin->assignRole($role->name);
}

}
