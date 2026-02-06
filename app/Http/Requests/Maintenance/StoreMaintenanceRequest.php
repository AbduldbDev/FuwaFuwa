<?php

namespace App\Http\Requests\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maintenance_type' => 'required|in:Corrective,Preventive,Inspection',
            'description' => 'nullable|string',
            'document.*' => 'nullable|file|max:25600',
            'asset_tag' => ['required', 'string', 'max:100', 'exists:assets,asset_tag'],
            'asset_name' => 'required|string|max:255',
            'last_maintenance_date' => 'nullable|date',
            'priority' => 'required|in:Low,Medium,High,Emergency',
            'start_date' => 'nullable|date',
            'frequency' => 'nullable|string|max:50',
            'technician' => 'nullable|string|max:255',
            'post_description' => 'nullable|string|max:255',
            'post_replacements' => 'nullable|string|max:255',
            'technician_notes'  => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'asset_tag.exists' => 'The selected asset tag does not exist.',
            'asset_tag.required' => 'The selected asset tag does not exist.',
            'document.*.file' => 'Each uploaded document must be a valid file.',
            'document.*.max'  => 'Each document must not exceed 25MB in size.',
        ];
    }
}
