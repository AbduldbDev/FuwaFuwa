<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ReportService;

class ReportAnalyticsController extends Controller
{

    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Maintenance', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('Maintenance', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();
       

        $data = $this->reportService->getDashboardData();

        return view('Pages/reports', $data);
    }

    public function download($id)
    {
        $report = Report::findOrFail($id);

        if (!$report->file_path || !Storage::exists($report->file_path)) {
            return abort(404, "Report file not found.");
        }

        return Storage::download($report->file_path);
    }
}
