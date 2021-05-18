<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

        // Validating incoming request params
        $validateCreds = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validateCreds->fails()) {
            return response([
                'success' => false,
                'error' => $validateCreds->errors()->all(),
            ], 422);
        }

        // Creds for login
        $creds = $request->only('email', 'password');

        // Generating JWT token from provided creds
        $token = JWTAuth::attempt($creds);
        if (!$token) {
            return response([
                'success' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        }

        // Authenticated user
        $user = auth()->user();

        // Adding token to user array
        $userArr = Arr::add($user, 'token', $token);
        return response([
            'success' => true,
            'user' => $userArr,
        ]);
    }

    // Register
    public function register(Request $request)
    {

        // Validating incoming request params
        $validateCreds = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if ($validateCreds->fails()) {
            return response([
                'success' => false,
                'error' => $validateCreds->errors()->all(),
            ], 422);
        }

        // Creating new user in database
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
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