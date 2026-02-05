<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assets;

class UpdateAssetCompliance extends Command
{
    protected $signature = 'assets:update-compliance';
    protected $description = 'Update compliance status of all assets';

    public function handle()
    {
        Assets::updateComplianceStatus();
        $this->info('Asset compliance statuses updated successfully.');
    }
}
