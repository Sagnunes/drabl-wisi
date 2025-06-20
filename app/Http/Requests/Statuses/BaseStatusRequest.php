<?php

namespace App\Http\Requests\Statuses;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BaseStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return false;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'description' => 'max:255',
        ];
    }
}
