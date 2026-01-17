<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'employee_id' => 'required|string|max:50|unique:users,employee_id',
            'department'  => 'required|string|max:100',
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:100|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'user_type'   => 'required|string',
            'status'      => 'required|in:active,inactive',
        ];
    }
}
