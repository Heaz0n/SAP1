<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\LoginDTO;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|alpha|min:7|regex:/^[A-Z][a-zA-Z]*$/',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[!@#$%^&*(),.?":{}|<>]/|regex:/[a-z]/|regex:/[A-Z]/',
        ];
    }

    public function toDto()
    {
        return new LoginDTO(
            $this->get('username'),
            $this->get('password')
        );
    }
}