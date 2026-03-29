<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'asset_categories';

    protected $fillable = [
        'requested_by',
        'name',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
