<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\RegisterDTO;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|alpha|min:7|regex:/^[A-Z][a-zA-Z]*$/|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[!@#$%^&*(),.?":{}|<>]/|regex:/[a-z]/|regex:/[A-Z]/|confirmed',
            'birthday' => 'required|date|before:today',
        ];
    }

    public function toDto()
    {
        return new RegisterDTO(
            $this->get('username'),
            $this->get('email'),
            $this->get('password'),
            $this->get('birthday')
        );
    }
}
