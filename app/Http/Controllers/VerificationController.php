<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {

        // Checking if the user exists
        $user = User::findOrFail($request->id);

        // Checking if the hash token is valid
        if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ]);
        }

        // Checking if the user email is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'User already verified!',
            ]);
        }

        // Verifying user email
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!',
        ]);
    }
}