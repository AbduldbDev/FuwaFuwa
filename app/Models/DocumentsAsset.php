<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentsAsset extends Model
{
    protected $table = 'asset_documents';
    protected $fillable = [
        'asset_id',
        'name',
        'file',
    ];
}
