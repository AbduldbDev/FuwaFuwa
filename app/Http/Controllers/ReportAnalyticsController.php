<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ReportService;
use App\Exports\CustomReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
    public function generateCustomReport(Request $request)
    {
        $reportType = $request->input('report_type');
        $columns = $request->input('columns', '');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$reportType || empty($columns)) {
            return back()->withErrors('Please select a report type and at least one column.');
        }

        if (!$startDate || !$endDate) {
            return back()->withErrors('Please select a start and end date.');
        }

        $columnsArray = array_filter(array_map('trim', explode(',', $columns)));

        if (empty($columnsArray)) {
            return back()->withErrors('Please select at least one column.');
        }

        $reportModels = [
            'assets' => [
                'model' => \App\Models\Assets::class,
                'relations' => ['vendor', 'users', 'technicalSpecifications'],
            ],
            'asset_requests' => [
                'model' => \App\Models\AssetRequest::class,
                'relations' => ['user'],
            ],
            'maintenances' => [
                'model' => \App\Models\Maintenance::class,
                'relations' => ['reporter'],
            ],
            'users' => [
                'model' => \App\Models\User::class,
                'relations' => [],
            ],
            'vendors' => [
                'model' => \App\Models\Vendors::class,
                'relations' => [],
            ],
        ];

        if (!isset($reportModels[$reportType])) {
            return back()->withErrors('Selected report type is invalid.');
        }

        $modelClass = $reportModels[$reportType]['model'];
        $relations = $reportModels[$reportType]['relations'];

        try {
            // Fetch data with relationships using Eloquent
            $dataQuery = $modelClass::with($relations)
                ->whereBetween('created_at', [$startDate, $endDate]);

            $data = $dataQuery->get();

            // Generate report name
            $timestamp = now()->format('Y_m_d_His');
            $reportName = $request->input('report_name', ucfirst(str_replace('_', ' ', $reportType)) . ' Report');
            $fileName = str_replace(' ', '_', $reportName) . '_' . $timestamp . '.xlsx';
            $filePath = "reports/{$fileName}";

            // Export with CustomReportExport
            $export = new CustomReportExport($data, $columnsArray);
            Excel::store($export, $filePath);

            Report::create([
                'type' => 'Custom Reports',
                'name' => $reportName,
                'file_path' => $filePath,
                'description' => $request->input('purpose'),
            ]);

            return back()->with('success', "Report generated successfully: {$fileName}");
        } catch (\Exception $e) {
            return back()->withErrors('Error generating report: ' . $e->getMessage());
        }
    }
}
