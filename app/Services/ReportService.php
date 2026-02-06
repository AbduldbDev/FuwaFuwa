<?php

namespace App\Services;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Assets;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use Illuminate\Support\Facades\Schema;

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
            'reportTables' => $this->getReportColumns(),
        ];
    }

    public function getReportColumns(): array
    {
        return [
            'assets' => [
                'Asset Details' => [
                    'asset_type',
                    'asset_category',
                    'asset_tag',
                    'asset_name',
                    'technical_specifications', // mapped from technicalSpecifications relation
                ],
                'Operational Status' => [
                    'operational_status',
                ],
                'Compliance Status' => [
                    'compliance_status',
                ],
                'Assignment and Location' => [
                    'assigned_to',
                    'department',
                    'location',
                ],
                'Purchase Information' => [
                    'vendor_id', // will map to vendor->name in export
                    'purchase_date',
                    'purchase_cost',
                ],
                'Depreciation Insights' => [
                    'useful_life_years',
                    'salvage_value',
                    'depreciation_expense', // computed
                    'current_value',        // computed
                    'years_used',           // computed
                    'remaining_life',       // computed
                    'depreciation_rate',    // computed
                ],
                'Maintenance and Audit' => [
                    'warranty_start',
                    'warranty_end',
                    'last_maintenance',
                    'next_maintenance',
                ],
            ],


            'asset_archive' => [
                'Asset Details' => [
                    'asset_type',
                    'asset_category',
                    'asset_tag',
                    'asset_name',
                    'technical_specifications'
                ],
                'Operational Status' => [
                    'operational_status'
                ],
                'Compliance Status' => [
                    'compliance_status'
                ],
                'Assignment and Location' => [
                    'assigned_to',
                    'department',
                    'location'
                ],
                'Purchase Information' => [
                    'vendor_id',
                    'purchase_date',
                    'purchase_cost'
                ],
                'Depreciation Insights' => [
                    'useful_life_years',
                    'salvage_value'
                ],
                'Maintenance and Audit' => [
                    'warranty_start',
                    'warranty_end',
                    'last_maintenance',
                    'next_maintenance'
                ],
                'Archival Details' => [
                    'delete_title',
                    'delete_reason',
                ],
            ],


            'asset_requests' => [
                'Requester Information' => ['requested_by', 'department'],
                'Asset Specification' => ['asset_type', 'asset_category', 'quantity', 'model'],
                'Justification' => ['request_reason', 'detailed_reason'],
                'Asset Request Status' => ['status'],
            ],


            'maintenances' => [
                'Maintenance Info' => [
                    'maintenance_type',
                    'reported_by',
                    'description',
                    'asset_tag',
                    'asset_name',
                    'last_maintenance_date',
                    'priority',
                    'frequency',
                    'technician',
                ],
                'Activity Feed' => [
                    'post_description',
                    'post_replacements',
                    'technician_notes',
                    'start_date',
                    'completed_at',
                ],
            ],

            'users' => [
                'User Details' => ['name', 'username', 'department', 'user_type', 'status'],
            ],
            'vendors' => [
                'Vendor Details' => ['name', 'contact_person', 'contact_email', 'contact_number', 'category', 'status'],

            ],
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
