<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        return response([
            'message' => 'successfully create account',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::Where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'ایمیل یا پسورد اشتباه است .',
            ]);
        }

        $token = $user->createToken('myapptoken');
        // $token = auth()->user()->createToken('myapptoken')->plainTextToken;
        $response = [
            'message' => 'you are logged',
            'user' => $user,
            'token' => $token->plainTextToken,
            'time_expired' => '20 minutes',
            'expired_at' => jalaliDate($token->accessToken->expired_at, 'H:i:s Y/m/d')
            

            // 'expired_at' =>jalaliDate(now()->addMinutes(20), 'H:i:s Y/m/d') 
        ];
        return response($response);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'logged out',
        ]);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('myapptoken');
        return response()->json([
            'token' => $token->plainTextToken,
            'time_expired' => '20 minutes',
            'expired_at' => jalaliDate($token->accessToken->expired_at, 'H:i:s Y/m/d')
        ]);
    }
}
