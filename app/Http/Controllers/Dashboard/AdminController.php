<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralTrait;
use Spatie\Permission\Middlewares\PermissionMiddleware;


class AdminController extends Controller
{
    use GeneralTrait;
    #[PermissionMiddleware('admins-read', only: ['index'])]
    #[PermissionMiddleware('admins-create', only: ['create', 'store'])]
    #[PermissionMiddleware('admins-update', only: ['update'])]
    #[PermissionMiddleware('admins-delete', only: ['destroy'])]

    public function index()
    {
        $admins = Admin::where('is_admin', 1)->orderBy('created_at', 'desc')->paginate(5);
        return view('dashboard.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('Dashboard.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'role' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $filename = null;

        if ($request->has('image')) {
            $file = $request->file('image');
            $filename = $this->handle('image', 'admins');
        } else {
            $filename = 'user.png';
        }

        DB::beginTransaction();

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $filename,
            'is_admin' => 1,
            'is_superadmin' => 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $role = Role::findOrFail($request->role);
        $admin->assignRole($role);
        DB::commit();
        return redirect()->route('admins.index')->with('success','Data Added Successfully');
    }

    // public function show() {}

    public function edit($id)
    {
        $admins = Admin::findOrFail($id);
        return view('Dashboard.admins.edit', compact('admins'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'nullable',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        DB::beginTransaction();

        $filename = null;

        $data = $request->except('password', 'image');

        $admins = Admin::findOrFail($id);

        if ($request->has('image')) {
            $filename = $this->handle('image', 'admins');
            $data = array_merge($data, ['image' => $filename]);
        } else {
            // تعيين اسم الملف الافتراضي هنا
            $filename = 'user.png';
        }

        if (!is_null($request->password)) {
            $admins->update(['password' => Hash::make($request->password)]);
        }
        if ($request->is_active) {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        $data = array_merge($data, ["is_active" => $is_active]);


        if (Auth::user()->hasRole('Super Admin')) {
            // إذا كان المستخدم لديه صلاحية "Super Admin"، يمكنه تعديل المستخدمين الآخرين
            $adminsToEdit = Admin::findOrFail($id);
            $adminsToEdit->update($data);
        } else {
            // إذا لم يكن المستخدم الحالي "Super Admin"، يمكنه فقط تعديل بياناته الخاصة
            if (Auth::user()->id == $id) {
                $adminsToEdit = Auth::user();
                $adminsToEdit->update($data);
            } else {
                return redirect()->back()->withErrors(["error" => 'Not Allowed']);
            }
        } //منع المستخدم من التعديل ع مستخدم اخر والسماح للسوبر ادمن فقط

        if (Auth::user()->hasRole('Super Admin')) {
            // Update roles only if the user being edited is not a Super Admin
            if (!$admins->hasRole('Super Admin')) {
                $role = Role::findOrFail($request->role);
                if ($role) {
                    $admins->roles()->sync([$role->id]);
                    // $user->assignRole($role->id);
                } else {
                    $admins->assignRole($role->id);
                    // return redirect()->back()->withErrors(['role' => 'Invalid role selected']);
                }
            }
        } //منع المستخدم من التعديل علي الصلاحيات والسماح للسوبر ادمن فقط
        DB::commit();
        return redirect()->route('admins.index')->with('success','Data updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admins.index')->with('success','Data deleted successfully.');
    }
}
