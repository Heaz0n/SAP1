<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenValue = $request->header('Authorization');
        if (!$tokenValue) {
            return response()->json(['message' => 'Authorization header not found'], 401);
        }

        $tokenValue = str_replace('Bearer ', '', $tokenValue);
        $token = Token::where('token', $tokenValue)->first();

        if (!$token) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        Auth::login($token->user);

        return $next($request);
    }
}
