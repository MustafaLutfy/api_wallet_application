<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request){
        $registerUserData = $request->validated();
        $user = User::create([
            'name' => $registerUserData['name'],
            'phone' => $registerUserData['phone'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        $user = Wallet::create([
            'user_id' => $user->id,
        ]);
        return response()->json([
            'message' => 'User Created ',
        ]);
    }

    public function login(LoginRequest $request){
        $loginUserData = $request->validated();
        $user = User::where('phone',$loginUserData['phone'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
