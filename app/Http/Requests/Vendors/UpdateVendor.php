<?php

namespace App\Http\Requests\Vendors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendor extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $vendorId = $this->route('vendor');

        return [
            'name' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'contact_email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('vendors', 'contact_email')->ignore($vendorId),
            ],
            'contact_number' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive',
        ];
    }
}
