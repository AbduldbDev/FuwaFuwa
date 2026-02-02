<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

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
            'status'      => 'sometimes|in:active,deactivate',
        ];
    }
}
