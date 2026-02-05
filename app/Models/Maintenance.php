<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenances';
    protected $fillable = [
        'maintenance_id',
        'maintenance_type',
        'reported_by',
        'description',
        'documents',
        'asset_tag',
        'asset_name',
        'last_maintenance_date',
        'priority',
        'start_date',
        'frequency',
        'technician',
        'post_description',
        'post_replacements',
        'technician_notes',
        'status',
        'post_attachments',
        'completed_at'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
