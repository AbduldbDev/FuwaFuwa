<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asset_name' => 'sometimes|string|max:255',
            'asset_type' => 'sometimes|string|max:255',
            'asset_category' => 'sometimes|string|max:255',
            'operational_status' => 'sometimes|string|max:50',
            'assigned_to' => 'sometimes|string|max:255',
            'department' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'vendor_id' => 'sometimes|string|max:255',
            'purchase_date' => 'sometimes|date',
            'purchase_cost' => 'sometimes|numeric',
            'compliance_status' => 'sometimes|string|max:255',
            'warranty_start' => 'sometimes|date',
            'warranty_end' => 'sometimes|date',
            'next_maintenance' => 'nullable',
            'last_maintenance' => 'nullable',
            'useful_life_years' => 'sometimes|integer|min:0',
            'salvage_value' => 'sometimes|numeric|min:0',
            'documents.name.*'   => 'sometimes|string',
            'documents.file.*'   => 'file|max:25600',
            'technical' => 'sometimes|array',
            'technical.*' => 'nullable|string|max:255',
        ];
    }
}
