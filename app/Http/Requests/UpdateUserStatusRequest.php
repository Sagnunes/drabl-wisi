<?php

namespace App\Http\Requests;

use App\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateUserStatusRequest
 *
 * Form request for validating user status updates.
 */
class UpdateUserStatusRequest extends FormRequest
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
            'updatedStatus' => ['required', 'string']
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
            'updatedStatus.required' => 'A status is required',
            'updatedStatus.string' => 'The status must be a string'
        ];
    }

    /**
     * Get the validated status enum from the request.
     *
     * @return UserStatusEnum|null
     */
    public function getValidatedStatus(): ?UserStatusEnum
    {
        $validated = $this->validated();
        return UserStatusEnum::fromName($validated['updatedStatus']);
    }
}
