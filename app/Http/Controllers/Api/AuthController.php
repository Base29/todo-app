<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'register');
    }

    // Login
    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');
        $token = JWTAuth::attempt($creds);
        if (!$token) {
            return response([
                'success' => false,
            ], 401);
        }

        $user = auth()->user();
        $userArr = Arr::add($user, 'token', $token);
        return response([
            'success' => true,
            'user' => $userArr,
        ]);
    }

    // Register
    public function register(Request $request)
    {
        $creds = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'email' => $creds['email'],
            'password' => Hash::make($creds['password']),
        ]);

        return response([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function checkToken()
    {
        return response(['success' => true], 200);
    }

    // Logout
    public function logout()
    {
        auth()->logout();
        return response(['success' => true], 200);
    }
}