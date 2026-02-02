<?php

namespace App\Http\Requests\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCorrectiveMaintenance extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_description' => 'nullable|string|max:255',
            'post_replacements' => 'nullable|string|max:255',
            'technician_notes'  => 'nullable|string|max:255',
            'post_attachments.*' => 'nullable',
        ];
    }
}
