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

class AuthController extends Controller
{
    /**
     * Register a new user.
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        // Create DTO from request
        $userData = $request->createDTO();
        
        // Create user
        $user = User::create([
            'username' => $userData->username,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
            'birthday' => $userData->birthday,
        ]);

        // Create Registration DTO
        $registrationDTO = new RegistrationDTO(
            $user->username,
            $user->email,
            $request->input('password'),
            $user->birthday
        );

        // Return registration data as JSON
        return response()->json($registrationDTO->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Login a user and return a token.
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        // Create DTO from request
        $userData = $request->createDTO();

        // Find user by username
        $user = User::where('username', $userData->username)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($userData->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Revoke all existing tokens for the user
        $user->tokens()->delete();

        // Create a new token
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addDays(env('TOKEN_EXPIRATION_DAYS', 3));
        $token->save();

        // Create Auth DTO
        $authDTO = new AuthDTO(
            $tokenResult->accessToken,
            'Bearer',
            Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        );

        // Return token data as JSON
        return response()->json($authDTO->toArray());
    }

    /**
     * Get authenticated user details.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request): \Illuminate\Http\JsonResponse
    {
        $userDTO = new UserDTO($request->user());

        return response()->json($userDTO->toArray());
    }

    /**
     * Get active tokens for the authenticated user.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tokens(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $activeTokens = $user->tokens()->where('revoked', false)->get();

        return response()->json(['tokens' => $activeTokens]);
    }

    /**
     * Logout the authenticated user by revoking the current token.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse 
    {
        $request->user()->token()->revoke();
    
        return response()->json(["message" => "Logged out successfully"], Response::HTTP_OK);
    }
    
    /**
     * Logout the authenticated user by revoking all tokens.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutAll(Request $request): \Illuminate\Http\JsonResponse 
    {
        $request->user()->tokens()->delete();

        return response()->json(["message" => "All tokens revoked"], Response::HTTP_OK);
    }
}