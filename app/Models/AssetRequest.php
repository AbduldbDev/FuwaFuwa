<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    protected $table = 'asset_requests';

    protected $fillable = [
        'request_id',
        'user_id',
        'requested_by',
        'department',
        'asset_category',
        'asset_type',
        'quantity',
        'model',
        'request_reason',
        'detailed_reason',
        'status',
        'remarks',
        'is_approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
