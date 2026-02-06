<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    protected $table = 'vendors';

    protected $fillable = [
        'vendor_id',
        'name',
        'contact_person',
        'contact_email',
        'contact_number',
        'category',
        'status',
    ];

    public function documents()
    {
        return $this->hasMany(VendorDocuments::class, 'vendor_id', 'id');
    }

    public function purchases()
    {
        return $this->hasMany(Assets::class, 'vendor_id', 'id');
    }
}
