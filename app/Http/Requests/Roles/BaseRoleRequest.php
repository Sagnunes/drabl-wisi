<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class BaseRoleRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'max:255',
        ];
    }
}
