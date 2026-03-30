<?php

namespace App\Http\Requests\AssetRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'requested_by'    => 'required|string|max:255',
            'department'      => 'required|string|max:255',
            'asset_category'  => 'required|string|max:255',
            'asset_type'      => 'required|string|max:255',
            'model'           => 'required|string|max:255',
            'request_reason'  => 'required|string|max:255',
            'priority'        => 'required|string|max:255',
            'detailed_reason' => 'required|string',
            'remarks'         => 'nullable|string',

        ];
    }

    public function messages(): array
    {
        return [
            'requested_by.required'   => 'Requested by is required.',
            'department.required'     => 'Department is required.',
            'asset_category.required' => 'Asset category is required.',
            'asset_type.required'     => 'Asset type is required.',
        ];
    }
}
