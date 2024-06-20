<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\TwoFactorCodeMail;
use App\Models\User; // Убедитесь, что модель импортирована

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

        // Проверка на количество запросов
        if ($user->two_factor_expires_at && $user->two_factor_expires_at->gt(now()->subSeconds(30))) {
            return response()->json(['message' => 'Подождите перед запросом нового кода.'], 429);
        }

        // Генерация кода
        $user->generateTwoFactorCode();

        // Отправка кода пользователю
        Mail::to($user->email)->send(new TwoFactorCodeMail($user->two_factor_code));

        return response()->json(['message' => 'Код двухфакторной аутентификации отправлен.']);
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

        if ($user->two_factor_expires_at->lessThan(now())) {
            return response()->json(['message' => 'Код двухфакторной аутентификации истек.'], 422);
        }

        if ($request->input('two_factor_code') !== $user->two_factor_code) {
            return response()->json(['message' => 'Неверный код двухфакторной аутентификации.'], 422);
        }

        // Очистка кода и времени его действия после успешной валидации
        $user->resetTwoFactorCode();

        return response()->json(['message' => 'Код двухфакторной аутентификации подтвержден.']);
    }
}
