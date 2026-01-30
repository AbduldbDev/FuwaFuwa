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
            'vendor' => 'sometimes|string|max:255',
            'purchase_date' => 'sometimes|date',
            'purchase_cost' => 'sometimes|numeric',
            'compliance_status' => 'sometimes|string|max:255',
            'warranty_start' => 'sometimes|date',
            'warranty_end' => 'sometimes|date',
            'next_maintenance' => 'sometimes|date',
            'useful_life_years' => 'sometimes|integer|min:0',
            'salvage_value' => 'sometimes|numeric|min:0',
            'contract'           => 'nullable|file|mimes:pdf|max:25600',
            'purchase_order'     => 'nullable|file|mimes:pdf|max:25600',
            'technical' => 'sometimes|array',
            'technical.*' => 'nullable|string|max:255',
        ];
    }
}
