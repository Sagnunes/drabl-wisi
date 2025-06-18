<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RemoveRoleRequest
 *
 * Form request for validating role removals from users.
 */
class RemoveRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Authorization is handled by middleware in the routes file
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'exists:roles,id']
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'A user ID is required',
            'user_id.exists' => 'The selected user does not exist',
            'roles.required' => 'At least one role must be selected',
            'roles.array' => 'Roles must be provided as an array',
            'roles.*.required' => 'Role ID is required',
            'roles.*.exists' => 'One or more selected roles do not exist'
        ];
    }

    /**
     * Get the validated user ID from the request.
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->validated('user_id');
    }

    /**
     * Get the validated roles from the request.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->validated('roles');
    }
}
