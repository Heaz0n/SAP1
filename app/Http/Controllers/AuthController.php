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
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $userData = $request->createDTO();
        $user = User::create([
            'username' => $userData->username,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
            'birthday' => $userData->birthday,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $registrationDTO = new RegistrationDTO($user);

        return response()->json($registrationDTO->toArray(), Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $userdata = $request->createDTO();

        $user = User::where('username', $userdata->username)->first();

        if (!$user || !Hash::check($userdata->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $activeTokens = $user->tokens()->where('revoked', 0)->latest()->get();
        $activeTokenCount = $activeTokens->count();

        if ($activeTokenCount >= env('MAX_ACTIVE_TOKENS', 3)) {
            $oldestActiveToken = $activeTokens->last();
            $oldestActiveToken->revoke();
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addDays(env('TOKEN_EXPIRATION_DAYS', 15));
        $token->save();

        $authDTO = new AuthDTO($tokenResult->accessToken, 'Bearer', Carbon::parse($tokenResult->token->expires_at)->toDateTimeString());

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
        $activeTokens = $user->tokens()->where('revoked', 0)->get();

        return response()->json(['tokens' => $activeTokens]);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->token()->revoke();

        return response()->json(["message" => "Token is logout"], 200);
    }

    public function logoutAll(Request $request) {
        $user = $request->user();

        $user->tokens->each(function($token, $key) {
            $token->revoke();
        });

        return response()->json(["message" => "All tokens are logged out"], 200);
    }
}
