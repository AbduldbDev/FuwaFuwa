<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetLogs extends Model
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'action',
        'field_name',
        'old_value',
        'new_value',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
