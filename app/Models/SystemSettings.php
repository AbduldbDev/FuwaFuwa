<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'asset_tag_prefix',
        'maintenance_reminders',
        'warranty_expiry_alerts',
        'asset_assignment_alerts',
        'report_generation',
    ];
}
