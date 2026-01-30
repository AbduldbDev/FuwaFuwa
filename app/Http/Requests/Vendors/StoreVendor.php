<?php

namespace App\Http\Requests\Vendors;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendor extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'contact_email' => 'required|email|max:50',
            'contact_number' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive',
        ];
    }
}
