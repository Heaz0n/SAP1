<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\DTO\UserDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $registerDTO = $request->toDTO(RegisterDTO::class);

        $user = new User();
        $user->username = $registerDTO->username;
        $user->email = $registerDTO->email;
        $user->password = Hash::make($registerDTO->password);
        $user->birthday = $registerDTO->birthday;

        $user->save();

        return response()->json(new UserDTO(
            $user->id,
            $user->username,
            $user->email,
            $user->birthday,
            $user->created_at,
            $user->updated_at
        ), 201);
    }

    public function login(LoginRequest $request)
    {
        $loginDTO = $request->toDTO(LoginDTO::class);

        if (Auth::attempt(['username' => $loginDTO->username, 'password' => $loginDTO->password])) {
            $user = Auth::user();
            $token = Passport::actingAs($user)->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid username or password'], 401);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $userDTO = new UserDTO(
            $user->id,
            $user->username,
            $user->email,
            $user->birthday,
            $user->created_at,
            $user->updated_at
        );

        return response()->json(['user' => $userDTO->toArray()], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'User successfully logged out'], 200);
    }

    public function tokens(Request $request)
    {
        $tokens = $request->user()->tokens;

        return response()->json(['tokens' => $tokens], 200);
    }

    public function revokeAllTokens(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'All user tokens revoked'], 200);
    }
}