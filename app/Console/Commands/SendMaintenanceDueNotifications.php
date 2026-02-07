<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assets;
use App\Models\Notification;
use App\Models\User;
use App\Models\SystemSettings;
use Carbon\Carbon;

class SendMaintenanceDueNotifications extends Command
{
    protected $signature = 'notify:maintenance-due';
    protected $description = 'Send daily notifications for assets with upcoming maintenance dates';

    public function handle()
    {
        $settings = SystemSettings::first();
        if (
            !$settings ||
            !isset($settings->maintenance_reminders) ||
            explode(',', $settings->maintenance_reminders)[0] != 1
        ) {
            $this->info('Maintenance reminders are disabled. Skipping notifications.');
            return 0;
        }

        $this->info('Checking for upcoming maintenance schedules...');

        $maintenanceAlerts = [
            'First Alert'  => 14,
            'Second Alert' => 7,
            'Final Alert'  => 1,
        ];

        $users  = User::all();
        $assets = Assets::whereNotNull('next_maintenance')->get();
        $today  = Carbon::today();

        foreach ($assets as $asset) {

            $maintenanceDate = Carbon::parse($asset->next_maintenance);
            $remainingDays   = $today->diffInDays($maintenanceDate, false);

            // Skip overdue
            if ($remainingDays < 0) {
                continue;
            }

            foreach ($maintenanceAlerts as $alertName => $triggerDays) {

                // ✅ Notify EVERY DAY once asset is inside the alert window
                if ($remainingDays <= $triggerDays) {

                    foreach ($users as $user) {

                        // ✅ Prevent duplicate notification for TODAY
                        $exists = Notification::where('user_id', $user->id)
                            ->where('module', 'asset_management')
                            ->where('type', 'maintenance_due')
                            ->where('title', "Maintenance Due Alert ({$alertName})")
                            ->whereDate('created_at', $today)
                            ->where('message', 'like', "%{$asset->asset_name}%")
                            ->exists();

                        if (!$exists) {
                            Notification::create([
                                'user_id' => $user->id,
                                'title'   => "Maintenance Due Alert ({$alertName})",
                                'message' => "The asset {$asset->asset_name} is scheduled for maintenance in {$remainingDays} day(s).",
                                'type'    => 'maintenance_due',
                                'module'  => 'asset_management',
                            ]);
                        }
                    }

                    $this->info(
                        "Daily maintenance alert ({$alertName}) sent for {$asset->asset_name} — {$remainingDays} day(s) remaining."
                    );
                }
            }
        }

        $this->info('Maintenance schedule check completed.');
        return 0;
    }
}
