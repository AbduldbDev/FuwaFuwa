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

        // Define report models and relationships
        $reportModels = [
            'assets' => [
                'model' => \App\Models\Assets::class,
                'relations' => ['vendor', 'users', 'technicalSpecifications'],
            ],
            'asset_archive' => [
                'model' => \App\Models\Assets::class,
                'relations' => ['vendor', 'users', 'technicalSpecifications'],
                'archived' => true,
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
            // Base query with date filter
            $dataQuery = $modelClass::with($relations)
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Special case for archived assets
            if (!empty($reportModels[$reportType]['archived']) && $reportModels[$reportType]['archived'] === true) {
                $dataQuery->where('operational_status', 'archived');
            } elseif ($reportType === 'assets') {
                // Exclude archived assets by default
                $dataQuery->where('operational_status', '!=', 'archived');
            }

            $data = $dataQuery->latest('updated_at')->get();

            // Compute depreciation and other fields for assets
            if (in_array($reportType, ['assets', 'asset_archive'])) {
                $data = $data->map(function ($asset) {
                    if ($asset->asset_type === 'Digital Asset') {
                        $asset->depreciation_expense = 0;
                        $asset->current_value = 0;
                        $asset->years_used = 0;
                        $asset->remaining_life = $asset->useful_life_years ?? 0;
                        $asset->depreciation_rate = 0;
                        return $asset;
                    }

                    $cost = $asset->purchase_cost ?? 0;
                    $salvage = $asset->salvage_value ?? 0;
                    $usefulLife = $asset->useful_life_years ?? 1;
                    $yearsUsed = $asset->purchase_date ? $asset->purchase_date->diffInYears(now()) : 0;

                    $depreciation = ($cost - $salvage) / $usefulLife;
                    $totalDepreciation = $depreciation * $yearsUsed;
                    $currentValue = max($cost - $totalDepreciation, $salvage);

                    // Round all numeric fields and format depreciation rate as percent
                    $asset->depreciation_expense = round($depreciation, 2);
                    $asset->current_value = round($currentValue, 2);
                    $asset->years_used = $yearsUsed;
                    $asset->remaining_life = max($usefulLife - $yearsUsed, 0);
                    $asset->depreciation_rate = round($usefulLife ? (($cost - $salvage) / $cost / $usefulLife) * 100 : 0, 2);

                    return $asset;
                });
            }

            // Generate report name and path
            $timestamp = now()->format('Y_m_d_His');
            $reportName = $request->input('report_name', ucfirst(str_replace('_', ' ', $reportType)) . ' Report');
            $fileName = str_replace(' ', '_', $reportName) . '_' . $timestamp . '.xlsx';
            $filePath = "reports/{$fileName}";

            // Export using CustomReportExport
            $export = new CustomReportExport($data, $columnsArray);
            Excel::store($export, $filePath);

            // Save report record
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
