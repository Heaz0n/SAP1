<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|min:7|alpha:ascii|regex:/^[A-Z]/',
            'password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()],
        ];
    }

    public function createDTO()
    {
        return (object) [
            'username' => $this->input('username'),
            'password' => $this->input('password'),
        ];
    }
}