<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');
        $token = JWTAuth::attempt($creds);
        if (!$token) {
            return response([
                'success' => false,
            ], 401);
        }

        return response([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function checkToken()
    {
        return response(['success' => true], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response(['success' => true], 200);
    }
}