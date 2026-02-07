<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assets;
use App\Models\TechnicalSpecification;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Models\SystemSettings;

class SendLicenseExpiryNotifications extends Command
{
    protected $signature = 'notify:license-expiry';
    protected $description = 'Send notifications for assets with licenses about to expire';

    public function handle()
    { // ✅ Check system settings
        $settings = SystemSettings::first();

        if (
            !$settings ||
            !isset($settings->warranty_expiry_alerts) ||
            explode(',', $settings->warranty_expiry_alerts)[0] != 1
        ) {
            $this->info('Warranty / license expiry alerts are disabled. Skipping notifications.');
            return 0;
        }

        $this->info('Checking for license expirations...');

        $subscriptionAlerts = [
            'Monthly' => [
                'First Alert'  => 7,
                'Second Alert' => 3,
                'Final Alert'  => 1,
            ],
            'Quarterly' => [
                'First Alert'  => 30,
                'Second Alert' => 14,
                'Final Alert'  => 3,
            ],
            'Annual' => [
                'First Alert'  => 60,
                'Second Alert' => 30,
                'Final Alert'  => 7,
            ],
        ];

        $users = User::all();
        $assets = Assets::with('technicalSpecifications')->get();
        $today = Carbon::today();

        foreach ($assets as $asset) {

            // get subscription type
            $spec = $asset->technicalSpecifications
                ->where('spec_key', 'Subscription_Type')
                ->first();
            if (!$spec) continue;

            $subscriptionType = ucfirst(strtolower($spec->spec_value));

            if (!isset($subscriptionAlerts[$subscriptionType])) continue;

            $alerts = $subscriptionAlerts[$subscriptionType];

            // make sure warranty_end exists
            if (!$asset->warranty_end) continue;

            $expiryDate = Carbon::parse($asset->warranty_end);

            foreach ($alerts as $alertName => $daysBefore) {
                // define alert window
                $alertStartDate = $expiryDate->copy()->subDays($daysBefore);
                $alertEndDate = $expiryDate;

                // check if today is within alert window
                if ($today->between($alertStartDate->startOfDay(), $alertEndDate->endOfDay())) {

                    foreach ($users as $user) {
                        $exists = Notification::where('user_id', $user->id)
                            ->where('module', 'asset_management')
                            ->where('type', 'license_expiry')
                            ->where('title', "License Expiry Alert ({$alertName})")
                            ->where('message', 'like', "%{$asset->asset_name}%")
                            ->exists();

                        if (!$exists) {
                            Notification::create([
                                'user_id' => $user->id,
                                'title' => "License Expiry Alert ({$alertName})",
                                'message' => "The license for asset {$asset->asset_name} will expire in {$daysBefore} day(s).",
                                'type' => 'license_expiry',
                                'module' => 'asset_management',
                            ]);
                        }
                    }

                    $this->info("Notification sent for asset: {$asset->asset_name} ({$subscriptionType}) to all users for {$alertName}.");
                }
            }
        }

        $this->info('License expiration check completed.');
        return 0;
    }
}
