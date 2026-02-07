<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssets extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_name'         => 'required|string|max:255',
            'vendor_id'          => ['required', 'exists:vendors,id'],
            'asset_category'     => 'required|string',
            'asset_type'         => 'required|string',
            'assigned_to'        => 'nullable|string',
            'department'         => 'nullable|string',
            'location'           => 'nullable|string',
            'purchase_date'      => 'nullable|date',
            'purchase_cost'      => 'required|numeric',
            'useful_life_years'  => 'nullable|integer',
            'salvage_value'      => 'nullable|numeric',
            'warranty_start'     => 'required|date',
            'warranty_end'       => 'required|date',
            'next_maintenance'   => 'nullable|date',
            'last_maintenance'   => 'nullable|date',
            'specs'              => 'nullable|array',
            'specs.*'            => 'nullable|string',
            'documents' => 'nullable|array',
            'documents.name.*' => 'required_with:documents|string|max:255',
            'documents.file.*' => 'required_with:documents|file|max:25600',
            'assetQuantity'      => 'nullable|integer',
            'AssetRequestId'      => 'nullable|integer',
        ];
    }



    public function messages(): array
    {
        return [
            'asset_name.required'     => 'Asset name is required.',
            'asset_name.string'       => 'Asset name must be a valid string.',
            'asset_name.max'          => 'Asset name must not exceed 255 characters.',

            'asset_category.required' => 'Asset category is required.',
            'asset_category.string'   => 'Asset category must be a valid string.',

            'asset_type.required'     => 'Asset type is required.',
            'asset_type.string'       => 'Asset type must be a valid string.',

            'operational_status.string' => 'Operational status must be a valid string.',
            'vendor_id.exists'         => 'Selected vendor does not exist.',
            'vendor_id.required'         => 'Vendor field is required.',


            'purchase_date.date'      => 'Purchase date must be a valid date.',
            'purchase_cost.numeric'   => 'Purchase cost must be a valid number.',
            'useful_life_years.integer' => 'Useful life years must be a whole number.',
            'salvage_value.numeric'   => 'Salvage value must be a valid number.',

            'compliance_status.string' => 'Compliance status must be a valid string.',
            'warranty_start.date'     => 'Warranty start date must be a valid date.',
            'warranty_end.date'       => 'Warranty end date must be a valid date.',
            'next_maintenance.date'   => 'Next maintenance must be a valid date.',

            'specs.array'             => 'Technical specifications must be a valid list.',
            'specs.*.string'          => 'Each technical specification must be a valid string.',
        ];
    }
}
