<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssets extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'asset_name'         => 'required|string|max:255',
            'asset_category'     => 'required|string',
            'asset_type'         => 'required|string',

            'operational_status' => 'nullable|string',
            'assigned_to'        => 'nullable|string',
            'department'         => 'nullable|string',
            'location'           => 'nullable|string',
            'vendor'             => 'nullable|string',

            'purchase_date'      => 'nullable|date',
            'purchase_cost'      => 'nullable|numeric',
            'useful_life_years'  => 'nullable|integer',
            'salvage_value'      => 'nullable|numeric',

            'compliance_status'  => 'nullable|string',
            'warranty_start'     => 'nullable|date',
            'warranty_end'       => 'nullable|date',
            'next_maintenance'   => 'nullable|date',

            // Technical specs (dynamic)
            'specs'              => 'nullable|array',
            'specs.*'            => 'nullable|string',
        ];
    }
}
