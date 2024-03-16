<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUsersData(Request $request) {
        $user = Auth::user();
    
        $userData = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'second_name' => $user->second_name,
            'business_name' => $user->business_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'type' => $user->type,
            'address' => $user->address,
            'profile_picture_url' => $user->profile_picture ? Storage::disk('public')->url($user->profile_picture) : null,
            'banner_url' => $user->banner ? Storage::disk('public')->url($user->banner) : null
        ];

        return response()->json($userData, 201);
    }
}
