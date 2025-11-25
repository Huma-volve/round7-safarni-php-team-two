<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\LoginRequest;

class AuthController extends Controller
{
    public function getlogin()
    {
        return view('dashboard.auth.login');
    }

   public function login(LoginRequest $request)
{
    try {

        $credentials = $request->validated();
        $remember = $request->boolean('remember_me'); // ← استخدم الريمبر الحقيقي

        // محاولة تسجيل الدخول
        if (auth()->guard('admins')->attempt($credentials, $remember)) {

            $admin = auth()->guard('admins')->user();

            // لو الحساب متوقف
            if ($admin->is_active == 0) {
                auth()->guard('admins')->logout();
                return redirect()
                    ->route('getlogin')
                    ->with(['error' => 'Your account has been deactivated.']);
            }

            // نجاح الدخول
            return redirect()->route('/');
        }

        // لو البيانات غلط
        return redirect()
            ->route('getlogin')
            ->with(['error' => 'Invalid email or password.']);

    } catch (\Throwable $e) {
        report($e);
        return back()->with(['error' => 'Something went wrong']);
    }
}
    public function logout()
    {
        auth()->guard('admins')->logout();
        return redirect()->route('getlogin');
    }


}

