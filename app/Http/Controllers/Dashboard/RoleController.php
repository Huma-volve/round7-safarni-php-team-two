<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use Spatie\Permission\Middlewares\PermissionMiddleware;



class RoleController extends Controller
{

    use GeneralTrait;

    #[PermissionMiddleware('roles-read', only: ['index'])]
    #[PermissionMiddleware('roles-create', only: ['create', 'store'])]
    #[PermissionMiddleware('roles-update', only: ['update'])]
    #[PermissionMiddleware('roles-delete', only: ['destroy'])]
    #[PermissionMiddleware('roles-permission', only: ['getpermissions'])]

    
    public function index(Request $request)
    {
        $roles = Role::where('name', '!=', 'Super Admin')->orderBy('created_at', 'desc')->paginate(5);

        return view('Dashboard.roles.index', compact('roles'));
    }


    public function create()
    {
        return view('Dashboard.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:100|min:3',

        ]);

        try {
            Role::create([
                'name' => $request->name,
                'guard_name' => 'admins',
            ]);
            return redirect()->route('roles.index')->with('success', 'Data created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with(["error" => trans('dashboard.somthing_wrong.')]);
        }
    }

    public function show($id) {}

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('Dashboard.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:100|min:3',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        return redirect()->route('roles.index')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Data deleted successfully.');
    }

    public function getpermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('Dashboard.roles.permissions', compact('role', 'permissions', 'id'));
    }



    public function updategetpermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if (!$role) {
            return redirect()->route('roles.index')->with("error", 'role not found.');
        }
        if (!empty($request->has('permission')) && is_array($request->permission)) {
            // تحقق من وجود أي صلاحيات في الطلب
            if ($request->has('permission') && is_array($request->permission)) {
                // مزامنة الصلاحيات الجديدة
                $permissions = Permission::whereIn('id', $request->permission)->get();
                $role->syncPermissions($permissions);
            } else {
                // إزالة جميع الصلاحيات إذا لم يتم تحديد أي صلاحية
                $role->syncPermissions([]);
            }
        } else {

            return redirect()->back()->with("error", 'No Permission provided');
        }

        return redirect()->route('roles.index')->with('success', 'Data updated successfully.');
    }
}
