<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('login')
    }
    public function login()
    {

    }

    public function checkToken()
    {

    }
}