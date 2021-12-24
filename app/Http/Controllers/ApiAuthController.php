<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'first_name' =>'required|string',
            'last_name' =>'required|string',
            'email'=>'required|string|email|unique:users,email',
            'password' =>'required'
        ]);

        $user = User::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'email'=>$fields['email'],
            'password'=>Hash::make($fields['password']),
        ]);

        //create token
        $token = $user->createToken(config('app.name'))->plainTextToken;

        return response($token);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|email',
            'password' =>'required'
        ]);

        $user = User::where('email',$fields['email'])->first();

        if(!$user || !Hash::check($fields['password'],$user->password)) {
            return response(['status'=>false,'message'=>'invalid email or password'],401);
        }

        //create token
        $token = $user->createToken(config('app.name'))->plainTextToken;

        $response = [
            'status'=>true,
            'message'=>'Login successful!',
            'data' =>[
                'user'=>$user,
                'token'=>$token
            ]
        ];
        return response($response,201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        $response = [
            'status'=>true,
            'message'=>'Logout successfully',
        ];

        return response($response,200);
    }
}
