<?php

namespace App\Http\Requests\AssetRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequestStatus extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'  => 'required|string',
            'remarks' => 'nullable|string|max:1000',
            'asset_tag' => ['nullable', 'string', 'max:100', 'exists:assets,asset_tag'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'The status field is required.',
            'status.in'       => 'The selected status is invalid.',
            'remarks.max'     => 'Remarks cannot exceed 1000 characters.',
            'asset_tag.exists' => 'The selected asset tag does not exist.',
        ];
    }
}
