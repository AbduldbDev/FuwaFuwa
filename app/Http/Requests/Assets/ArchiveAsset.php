<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveAsset extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'delete_title'         => 'required|string|max:255',
            'delete_reason'         => 'required|string',
        ];
    }
}
