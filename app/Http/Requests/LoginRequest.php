<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|alpha|starts_with:^[A-Z]|min:7',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/',
        ];
    }
}
