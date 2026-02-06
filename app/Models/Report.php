<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['name', 'file_path', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
