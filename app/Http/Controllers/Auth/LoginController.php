<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\sendOtpMail;



class LoginController extends Controller
{
   public function register(Request $request)
{
    $user = User::create([
        'name'    => $request->name,
        'email'   => $request->email,
        'phone'   => $request->phone,
        'address' => $request->address,
        'password'=> Hash::make($request->password),
    ]);
    $otp = rand(100000, 999999);
    $user->update([
        'otp_code' => $otp,
        'otp_expires_at' => now()->addMinutes(15),
    ]);

    // Mail::raw("Your OTP verification code is: $otp", function($mail) use ($user) {
    //     $mail->to($user->email)
    //          ->subject("Verify Your Email");
    // });

       Mail::to($request->email)->send(new sendOtpMail($otp,$user));
    return response()->json([

        'message' => 'Registered successfully. Please verify your email with the OTP sent.',
        'email'   => $user->email,
    ]);
}



public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp_code'   => 'required'
    ]);

    $user = User::where('email', $request->email)
        ->where('otp_code', $request->otp_code)
        ->where('otp_expires_at', '>', now())
        ->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid or expired OTP'], 400);
    }

    $user->update([
        'email_verified_at' => now(),
        'otp_code' => null,
        'otp_expires_at' => null,
    ]);

    return response()->json([
        'message' => 'Account verified successfully',
        'token'   => $user->createToken('auth')->plainTextToken,
        'user'    => $user
    ]);
}


public function resendOtp(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
        ]);


        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $otp = rand(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15)
        ]);

         Mail::to($request->email)->send(new sendOtpMail($otp,$user));
        return response()->json([
            'message' => 'OTP resent successfully',
            'otp_code' => $otp
        ]);
    }



   public function login(LoginRequest $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    if (is_null($user->email_verified_at)) {
        return response()->json([
            'message' => 'Please verify your email first.',
        ], 403);
    }
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}

public function forgotPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Email not found'], 404);
    }

    $otp = rand(100000, 999999);

    $user->otp_code = $otp;
    $user->otp_expires_at = now()->addMinutes(15);
    $user->save();

     Mail::to($request->email)->send(new sendOtpMail($otp,$user));
    return response()->json([
        'message' => 'OTP sent to your email',
        'email'   => $user->email
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp_code' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)
        ->where('otp_code', $request->otp_code)
        ->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid OTP'], 400);
    }

    if ($user->otp_expires_at < now()) {
        return response()->json(['message' => 'OTP expired'], 400);
    }

    $user->password = Hash::make($request->password);

    $user->otp_code = null;
    $user->otp_expires_at = null;
    $user->save();

    return response()->json([
        'message' => 'Password has been reset successfully'
    ]);
}


     public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function googleRedirect()
{
    return Socialite::driver('google')->stateless()->redirect();
}

public function googleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
    }
    catch (\Exception $e) {
        return response()->json(['error' => 'Unable to login with Google'], 400);
    }

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name'     => $googleUser->getName(),
            'email'    => $googleUser->getEmail(),
            'google_id'=> $googleUser->getId(),
            'password' => Hash::make(uniqid()),
            'email_verified_at' => now(),
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Logged in with Google',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}


}
