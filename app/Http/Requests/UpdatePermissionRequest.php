<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\PermissionDTO;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->route('permission'),
            'description' => 'nullable|string',
            'code' => 'required|string|max:255|unique:permissions,code,' . $this->route('permission'),
        ];
    }

    public function createDTO()
    {
        return new PermissionDTO(
            $this->input('name'),
            $this->input('description'),
            $this->input('code')
        );
    }
}
