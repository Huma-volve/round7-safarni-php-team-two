<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         if (Auth::check()) {
            $userStatus = DB::table('admins')->where('id', Auth::id())->value('is_active');

            if ($userStatus === 0) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with("error", 'user_deactivated');
            }
        }
        return $next($request);
    }
}
