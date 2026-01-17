<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'employee_id' => 'sometimes|string|max:50',
            'department'  => 'sometimes|string|max:100',
            'name'        => 'sometimes|string|max:255',
            'username'    => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'user_type'   => 'sometimes|string',
            'status'      => 'sometimes|in:active,inactive',
        ];
    }
}
