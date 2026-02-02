<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPurchase extends Model
{

    protected $table = 'vendor_purchases';
    protected $fillable = [
        'vendor_id',
        'order_id',
        'item_name',
        'quantity',
        'cost',
        'expiration',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendors::class, 'vendor_id');
    }
}
