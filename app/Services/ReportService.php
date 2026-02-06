<?php

namespace App\Services;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Assets;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

class ReportService
{
    public function getDashboardData(): array
    {
        return [
            'reports' => $this->getReports(),
            'TotalGeneratedReport' => $this->getTotalGeneratedReports(),
            'LastGeneratedReport' => $this->getLastGeneratedReport(),
            'TotalScheduledMonthlyReports' => $this->getTotalScheduledMonthlyReports(),
            'TotalCustomReportsCreated' => $this->getTotalCustomReportsCreated(),
        ];
    }

    public function getReports()
    {
        return Report::latest()->get();
    }

    public function getTotalGeneratedReports(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Report::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
    }

    public function getLastGeneratedReport()
    {
        return Report::latest()->first();
    }

    public function getTotalScheduledMonthlyReports()
    {
        return Report::where('type', 'Scheduled Reports')->count();
    }

    public function getTotalCustomReportsCreated()
    {
        return Report::where('type', 'Custom Reports')->count();
    }
}
