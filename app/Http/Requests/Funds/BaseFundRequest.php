<?php

namespace App\Http\Requests\Funds;

use Illuminate\Foundation\Http\FormRequest;

class BaseFundRequest extends FormRequest
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
            'acronym' => 'required|string|max:255',
            'name' => 'max:255',
        ];
    }
}
