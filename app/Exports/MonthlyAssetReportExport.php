<?php

namespace App\Exports;

use App\Models\Assets;
use App\Models\Maintenance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MonthlyAssetReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new \App\Exports\Sheets\AssetSummarySheet(),
            new \App\Exports\Sheets\AssetTableSheet(),
            new \App\Exports\Sheets\ArchivedAssetsSheet(),
            new \App\Exports\Sheets\StatusBreakdownSheet(),
            new \App\Exports\Sheets\AssetValueSheet(),
            new \App\Exports\Sheets\MaintenanceSheet(),
        ];
    }
}
