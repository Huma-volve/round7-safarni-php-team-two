<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
                            ['name' => 'dashboard','guard'=> 'admins'],
                            ['name' => 'admins-read','guard'=> 'admins'],
                            ['name' => 'admins-create','guard'=> 'admins'],
                            ['name' => 'admins-update','guard'=> 'admins'],
                            ['name' => 'admins-delete','guard'=> 'admins'],

                            ['name' => 'roles-read','guard'=> 'admins'],
                            ['name' => 'roles-create','guard'=> 'admins'],
                            ['name' => 'roles-update','guard'=> 'admins'],
                            ['name' => 'roles-delete','guard'=> 'admins'],
                            ['name' => 'roles-permission','guard'=> 'admins'],


        ];
        foreach ($permissions as $permission)
        {
            Permission::firstOrCreate([
                                    'name' => $permission['name'],
                                    'guard_name' => $permission['guard']
                                ]);
        }

        // $admin = Admin::firstOrCreate([
        //     'name_ar' => 'superadmin',
        //     'name_en' => 'superadmin',
        //     'email' => 'superadmin@superadmin.com',
        //     'image' => 'user.png',
        //     'password' => bcrypt('123456'),
        //     'is_superadmin' => 1,
        //     'is_admin' => 0,
        //     'is_active' => 1,
        // ]);
        $role = Role::firstOrCreate(['name' => 'Super Admin','guard_name' => 'admins']);

        // جلب جميع الصلاحيات
        $permissions = Permission::all();

        // تعيين جميع الصلاحيات لدور السوبر أدمن
        $role->syncPermissions($permissions);

        // تعيين دور السوبر أدمن للمستخدم
        // $admin->assignRole($role->name);

}


}//end of permission
