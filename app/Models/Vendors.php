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
}
