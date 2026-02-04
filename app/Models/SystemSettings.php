<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'physical_tag_prefix',
        'digital_tag_prefix',
        'maintenance_reminders',
        'warranty_expiry_alerts',
        'asset_assignment_alerts',
        'report_generation',
    ];
}
