<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    protected $table = 'asset_requests';

    protected $fillable = [
        'request_id',
        'asset_tag',
        'user_id',
        'category_id',
        'requested_by',
        'department',
        'asset_category',
        'asset_type',
        'model',
        'request_reason',
        'detailed_reason',
        'status',
        'remarks',
        'priority',
        'is_approved',
        'is_added',
        'is_procured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_tag', 'asset_tag');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }
}
