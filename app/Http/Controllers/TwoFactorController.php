<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;

class TwoFactorController extends Controller
{
    /**
     * Generate a new two-factor authentication code and send it to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request)
    {
        $user = Auth::user();

        // Ensure $user is not null
        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        // Check if there is already a valid code within the last 30 seconds
        if ($this->twoFactorCodeExpired($user)) {
            return response()->json(['message' => 'Please wait before requesting a new code.'], 429);
        }

        // Generate a new code
        $twoFactorCode = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(config('auth.two_factor_expiration'));

        // Update user's two-factor authentication fields
        $user->two_factor_code = $twoFactorCode;
        $user->two_factor_expires_at = $expiresAt;

        // Save changes to the user model
        $user->save();

        // Send the code to the user via email
        Mail::to($user->email)->send(new TwoFactorCodeMail($twoFactorCode));

        return response()->json(['message' => 'Two-factor authentication code sent.']);
    }

    /**
     * Validate the two-factor authentication code provided by the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        // Ensure $user is not null
        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        // Check if the code has expired
        if ($this->twoFactorCodeExpired($user)) {
            return response()->json(['message' => 'Two-factor authentication code has expired.'], 422);
        }

        // Check if the provided code matches the stored code
        if ($request->input('two_factor_code') !== $user->two_factor_code) {
            return response()->json(['message' => 'Invalid two-factor authentication code.'], 422);
        }

        // Clear the code and its expiration time after successful validation
        $this->clearTwoFactorCode($user);

        return response()->json(['message' => 'Two-factor authentication code confirmed.']);
    }

    /**
     * Check if the two-factor authentication code has expired.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    private function twoFactorCodeExpired($user)
    {
        return $user->two_factor_expires_at && $user->two_factor_expires_at->lt(now());
    }

    /**
     * Clear the two-factor authentication code and its expiration time.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private function clearTwoFactorCode($user)
    {
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;

        // Save changes to the user model
        $user->save();
    }
}