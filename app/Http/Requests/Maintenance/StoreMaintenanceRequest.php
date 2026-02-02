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
            'document.*' => 'nullable|file|mimes:pdf,jpg,png,docx|max:25600',
            'asset_tag' => 'nullable|string|max:100',
            'asset_name' => 'nullable|string|max:255',
            'last_maintenance_date' => 'nullable|date',
            'priority' => 'required|in:Low,Medium,High,Emergency',
            'start_date' => 'nullable|date',
            'frequency' => 'nullable|string|max:50',
            'technician' => 'nullable|string|max:255',
        ];
    }
}
