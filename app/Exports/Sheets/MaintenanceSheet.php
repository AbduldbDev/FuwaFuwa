<?php

namespace App\Exports\Sheets;

use App\Models\Maintenance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class MaintenanceSheet implements FromArray, WithTitle, WithStyles
{
    public function array(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get all maintenance for the month WITH logs
        $maintenanceItems = Maintenance::with(['reporter', 'logs'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();

        // Dashboard counts
        $totalScheduled = $maintenanceItems->count();
        $totalCompleted = $maintenanceItems->whereNotNull('completed_at')->count();

        // 💰 Total monthly maintenance cost
        $totalMonthlyCost = $maintenanceItems->sum(function ($m) {
            return $m->logs?->sum(fn($log) => $log->cost ?? 0) ?? 0;
        });

        $rows = [];

        /** =======================
         * DASHBOARD SECTION
         * ======================= */
        $rows[] = ['Maintenance Dashboard'];

        $rows[] = [
            'Total Scheduled Maintenance',
            $totalScheduled,
            'Total Completed Maintenance',
            $totalCompleted,
            'Total Maintenance Cost (₱)',
            '₱' . number_format($totalMonthlyCost, 2),
        ];

        /** =======================
         * TABLE HEADER
         * ======================= */
        $rows[] = [
            'Reported By',
            'Maintenance Type',
            'Asset Tag',
            'Asset Name',
            'Issue Description',
            'Action Taken',
            'Start Date',
            'Completion Date',
            'Maintenance Cost (₱)',
        ];

        /** =======================
         * MAINTENANCE ROWS
         * ======================= */
        foreach ($maintenanceItems as $m) {

            $maintenanceCost = $m->logs
                ? $m->logs->sum(fn($log) => $log->cost ?? 0)
                : 0;

            $rows[] = [
                $m->reporter->name ?? 'N/A',
                $m->maintenance_type ?? 'N/A',
                $m->asset_tag ?? 'N/A',
                $m->asset_name ?? 'N/A',
                $m->description ?? 'N/A',
                $m->post_description ?? 'N/A',
                $m->start_date
                    ? Carbon::parse($m->start_date)->format('M d, Y')
                    : 'N/A',
                $m->completed_at
                    ? Carbon::parse($m->completed_at)->format('M d, Y')
                    : 'N/A',
                '₱' . number_format($maintenanceCost, 2),
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Maintenance';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Dashboard title (row 1)
        $sheet->mergeCells("A1:{$highestColumn}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'fdb38e'],
            ],
        ]);

        // Dashboard counts (row 2)
        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Header for maintenance details (row 3)
        $sheet->getStyle('A3:I3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'fdb38e'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Data rows (row 4 to last)
        $sheet->getStyle("A4:I{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
