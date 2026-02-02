<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorDocuments extends Model
{
    protected $table = 'vendor_documents';
    protected $fillable = [
        'vendor_id',
        'name',
        'file',
        'expiration',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }
}
