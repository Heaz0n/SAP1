<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:roles,name,' . $this->route('id'),
            'description' => 'nullable|string|max:1000',
            'code' => 'required|string|max:50|unique:roles,code,' . $this->route('id'),
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
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',
            'name.unique' => 'Name already exists.',

            'description.string' => 'Description must be a string.',
            'description.max' => 'Description may not be greater than :max characters.',

            'code.required' => 'Code is required.',
            'code.string' => 'Code must be a string.',
            'code.max' => 'Code may not be greater than :max characters.',
            'code.unique' => 'Code already exists.',
        ];
    }
}
