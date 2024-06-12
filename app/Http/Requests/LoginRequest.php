<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\AuthDTO;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required|string|alpha|min:7',
            'password' => 'required|string|min:8',
        ];
    }

    public function createDTO()
    {
        return new AuthDTO(
            $this->input('username'),
            $this->input('password')
        );
    }
}
