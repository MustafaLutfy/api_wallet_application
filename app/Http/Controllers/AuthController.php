<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request){
        $registerUserData = $request->validated();
        // use Always database transactions when performing data manipulation for more than 1 query
        DB::transaction(function () use ($registerUserData){
            $user = User::create([
                'name' => $registerUserData['name'],
                'phone' => $registerUserData['phone'],
//            'password' => Hash::make($registerUserData['password']),
                // password is automatically hash by laravel cast
                'password' => $registerUserData['password']
            ]);

//            Wallet::create([
//                'user_id' => $user->id,
//            ]);
            //shorter syntax and do the same job
            $user->wallet()->create();
        });
        // if the operation above succeed this response will be given else a response with exception response
        return response()->json([
            'message' => 'User Created ',
        ],201);
        // always use right status code in responses
    }

    public function login(LoginRequest $request){
        $loginUserData = $request->validated();
        $user = User::where('phone',$loginUserData['phone'])->first();
        // $user->password can cause an error if the user is null use $user?->password or optional($user)->password
        if(!$user || !Hash::check($loginUserData['password'],$user?->password)){
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
        $request->user()->currentAccessToken()->delete();
        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
