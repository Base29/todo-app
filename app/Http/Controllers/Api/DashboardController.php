<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    pubclic function __construct()
    {
        $this->middleware('auth:api')
    }
    public function index() {

        return response([
            'success' => true,
            'message' => 'You are in the dashboard'
        ])

    }
}