<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetSettings extends Model
{
    protected $table = 'company_profile';
    protected $fillable = [
        'company_name',
        'brand_name',
        'contact_email',
        'contact_phone',
    ];
}
