<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only('username', 'password');
        
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $data = $request->only('username', 'email', 'password', 'birthday');

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthday' => $data['birthday'],
        ]);

        return response()->json(['message' => 'User registered successfully!'], 201);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function tokens(Request $request)
    {
        $tokens = $request->user()->tokens->pluck('name');
        return response()->json(['tokens' => $tokens], 200);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'All tokens successfully revoked'], 200);
    }
}
