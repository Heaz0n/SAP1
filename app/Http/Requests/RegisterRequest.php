<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|unique:users|min:7|alpha:ascii|regex:/^[A-Z]/',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()],
            'c_password' => 'required|same:password',
            'birthday' => 'required|date_format:Y-m-d',
        ];
    }

    public function createDTO()
    {
        return (object) [
            'username' => $this->input('username'),
            'email' => $this->input('email'),
            'password' => $this->input('password'),
            'birthday' => $this->input('birthday'),
        ];
    }
}
