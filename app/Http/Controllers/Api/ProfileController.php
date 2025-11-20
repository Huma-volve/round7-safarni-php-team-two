<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
        'data' => new UserResource(auth()->user()),
        'message' => 'User profile retrieved successfully'
    ], 200);
    }


   public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:users,email,' . $user->id,
        'phone'   => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('profile_images', 'public');
        $user->image = '/storage/' . $imagePath;
    }

    $user->fill($request->only(['name', 'email', 'phone', 'address']));
    $user->save();

    return response()->json([
        'data' => new UserResource($user),
        'message' => 'Profile updated successfully'
    ], 200);
}

}
