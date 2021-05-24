<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // if (!$request->hasValidSignature()) {
        //     return response([
        //         'success' => false,
        //         'message' => 'Invalid Signature',
        //     ], 253);
        // }

        // $user = User::findOrFail($user_id);

        // if (!$user->hasVerifiedEmail()) {
        //     $user->markEmailAsVerified();
        // }

        // return response([
        //     'success' => true,
        //     'message' => 'Email Verified',
        // ]);
        ray($request->all());
        $user = User::findOrFail($request->id);

        // do this check, only if you allow unverified user to login
        //        if (! hash_equals((string) $request->id, (string) $request->user()->getKey())) {
        //            throw new AuthorizationException;
        //        }

        if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'User already verified!',
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!',
        ]);
    }
}