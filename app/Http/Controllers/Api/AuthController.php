<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerClient(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'first_name' => 'required|string|between:2,20',
                'second_name' => 'required|string|between:2,20',
                'email' => 'required|email|max:50|unique:users,email',
                'phone_number' => 'required|string|between:7,15',
                'password' => 'required|string|min:6',
                'confirm_password' => 'string',
            ]);
    
            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 500);
            }
    
            $user = User::create([
                'first_name' => $request->first_name,
                'second_name' => $request->second_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
    
        } catch(Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email|between:3,50',
            'password' => 'required|between:6,30'
        ]);
    
        if(!Auth::attempt($credentials)) {
            return $this->errorResponse('Invalid email or password.', 401);
        }
    
        $user = Auth::user();
    
        if($user->banned) {
            return $this->errorResponse('Account banned', 403);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged in',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user_id' => $user->id
        ]);
    }

    protected function errorResponse($message, $status) {
        Auth::logout();
        return response()->json([
            'status' => false,
            'message' => $message
        ], $status);
    }
}
