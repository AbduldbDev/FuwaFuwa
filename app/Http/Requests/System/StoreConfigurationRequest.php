<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigurationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asset_tag_prefix' => 'nullable|string|max:10',
            'maintenance_reminders' => 'nullable|boolean',
            'warranty_expiry_alerts' => 'nullable|boolean',
            'asset_assignment_alerts' => 'nullable|boolean',
            'report_generation' => 'nullable|boolean',
        ];
    }
}
