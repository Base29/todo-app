<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request, $user_id)
    {
        if (!$request->hasValidSignature()) {
            return response([
                'success' => false,
                'message' => 'Invalid Signature',
            ], 253);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response([
            'success' => true,
            'message' => 'Email Verified',
        ]);
    }
}