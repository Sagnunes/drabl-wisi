<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class BaseRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ];
    }
}
