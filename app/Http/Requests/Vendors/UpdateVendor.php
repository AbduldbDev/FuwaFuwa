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

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:50',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Active,Inactive',

            'existing_documents' => 'array',
            'existing_documents.*.id' => 'required|integer|exists:vendor_documents,id',
            'existing_documents.*.name' => 'required|string|max:255',
            'existing_documents.*.expiration' => 'required|date',

            'delete_documents' => 'array',
            'delete_documents.*' => 'integer|exists:vendor_documents,id',

            'new_documents.name' => 'array',
            'new_documents.name.*' => 'required|string|max:255',
            'new_documents.expiry' => 'array',
            'new_documents.expiry.*' => 'required|date',
            'new_documents.file_name' => 'array',
            'new_documents.file_name.*' => 'required|string|max:255',

            'existing_purchases' => 'array',
            'existing_purchases.*.id' => 'required|integer|exists:vendor_purchases,id',
            'existing_purchases.*.po_id' => 'required|string|max:100',
            'existing_purchases.*.item_name' => 'required|string|max:255',
            'existing_purchases.*.quantity' => 'required|integer|min:1',
            'existing_purchases.*.cost' => 'required|numeric|min:0',
            'existing_purchases.*.expiration' => 'required|date',

            'delete_purchases' => 'array',
            'delete_purchases.*' => 'integer|exists:vendor_purchases,id',

            'new_purchases.order_id' => 'array',
            'new_purchases.order_id.*' => 'required|string|max:100',
            'new_purchases.item_name' => 'array',
            'new_purchases.item_name.*' => 'required|string|max:255',
            'new_purchases.quantity' => 'array',
            'new_purchases.quantity.*' => 'required|integer|min:1',
            'new_purchases.cost' => 'array',
            'new_purchases.cost.*' => 'required|numeric|min:0',
            'new_purchases.expiration' => 'array',
            'new_purchases.expiration.*' => 'required|date',
        ];
    }
}
