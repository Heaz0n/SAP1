<?php

namespace App\Http\Requests;

use App\DTOs\UserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Create a DTO representing the user with roles and permissions.
     *
     * @return UserDTO
     */
    public function createDTO(): UserDTO
    {
        $user = $this->user();
        $DTO = new UserDTO(
            $user->id,
            $user->username,
            $user->email,
            $user->birthday,
            $user->created_at
        );

        // Load roles with permissions for each role
        $DTO->roles = $user->roles()->with('permissions')->get();

        return $DTO;
    }
}
