<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class AssignAsset extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id'   => 'required|exists:assets,id',
            'request_id'   => 'required|exists:asset_requests,id',
            'assigned_to' => 'required|string|max:255',
            'department'  => 'required|string|max:255',
            'location'    => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Please select an asset.',
            'asset_id.exists'   => 'The selected asset is invalid.',
            'request_id.exists'   => 'The asset request is invalid.',
            'assigned_to.required' => 'Assigned To is required.',
            'department.required'  => 'Department is required.',
            'location.required'    => 'Location is required.',
        ];
    }
}
