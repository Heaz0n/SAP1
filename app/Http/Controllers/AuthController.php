<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DTOs\UserDTO;
use App\DTOs\AuthDTO;
use App\DTOs\RegistrationDTO;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) 
    {
        $userData = $request->createDTO();
        
        $user = User::create([
            'username' => $userData->username,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
            'birthday' => $userData->birthday,
        ]);

        $registrationDTO = new RegistrationDTO(
            $user->username,
            $user->email,
            $request->input('password'),
            $user->birthday
        );

        return response()->json($registrationDTO->toArray(), Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $userData = $request->createDTO();

        $user = User::where('username', $userData->username)->first();

        if (!$user || !Hash::check($userData->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Revoke all existing tokens for the user
        $user->tokens()->delete();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addDays(env('TOKEN_EXPIRATION_DAYS', 3));
        $token->save();

        $authDTO = new AuthDTO(
            $tokenResult->accessToken,
            'Bearer',
            Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        );

        return response()->json($authDTO->toArray());
    }

    public function me(Request $request)
    {
        $userDTO = new UserDTO($request->user());

        return response()->json($userDTO->toArray());
    }

    public function tokens(Request $request)
    {
        $user = $request->user();
        $activeTokens = $user->tokens()->where('revoked', false)->get();

        return response()->json(['tokens' => $activeTokens]);
    }

    public function logout(Request $request) 
    {
        $request->user()->token()->revoke();
    
        return response()->json(["message" => "Logged out successfully"], Response::HTTP_OK);
    }
    
    public function logoutAll(Request $request) 
    {
        $request->user()->tokens()->delete();

        return response()->json(["message" => "All tokens revoked"], Response::HTTP_OK);
    }
}