<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    protected $table = 'maintenance_logs';

    protected $fillable = [
        'maintenance_id',
        'type',
        'issue_description',
        'action_taken',
        'parts_replaced',
        'cost',
        'start_date',
        'completion_date',
        'technician_notes',
    ];


    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id', 'maintenance_id');
    }
}
