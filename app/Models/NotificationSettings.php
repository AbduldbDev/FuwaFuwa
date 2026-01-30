<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
{

    protected $table = 'notification_settings';
    protected $fillable = [
        'company_id',
        'email_notifications',
        'asset_assignment_alerts',
        'report_generation_alerts',
    ];
}
