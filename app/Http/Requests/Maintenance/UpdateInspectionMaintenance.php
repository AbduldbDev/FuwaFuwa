<?php

namespace App\Http\Requests\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInspectionMaintenance extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'condition' => 'required|string|max:255',
            'technician' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'document.*' => 'nullable',
        ];
    }
}
