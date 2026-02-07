<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyAssetReportExport;
use App\Models\Report;
use App\Models\SystemSettings;

class GenerateMonthlyAssetReport extends Command
{
    protected $signature = 'report:monthly-assets';
    protected $description = 'Generate monthly asset report';

    public function handle()
    {
        $settings = SystemSettings::first();

        if (
            !$settings ||
            !isset($settings->report_generation) ||
            explode(',', $settings->report_generation)[0] != 1
        ) {
            $this->info('Report generation is disabled. Skipping monthly report.');
            return 0;
        }

        $fileName = 'Monthly_Asset_Report_' . now()->format('Y_m') . '.xlsx';
        $filePath = "reports/{$fileName}";

        // Store Excel
        Excel::store(new MonthlyAssetReportExport(), $filePath);

        // Save to DB
        $report = Report::create([
            'type' => 'Scheduled Reports',
            'name' => 'Monthly Asset Report - ' . now()->format('F Y'),
            'file_path' => $filePath,
            'description' => 'This is a monthly automated report generated automatically.',
        ]);

        $this->info("Report generated: {$filePath}");
    }
}
