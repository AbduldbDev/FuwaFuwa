<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalSpecification extends Model
{

    protected $table = 'technical_specifications';

    protected $fillable = [
        'asset_id',
        'spec_key',
        'spec_value',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets::class);
    }
}
