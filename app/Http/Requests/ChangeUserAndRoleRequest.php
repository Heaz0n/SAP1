<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserAndRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Предположим, что проверка авторизации выполняется в middleware или контроллере.
        // Метод authorize() проверяет разрешения пользователя на выполнение запроса.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => 'User ID is required.',
            'id.exists' => 'User not found.',

            'role_id.required' => 'Role ID is required.',
            'role_id.exists' => 'Role not found.',
        ];
    }
}
