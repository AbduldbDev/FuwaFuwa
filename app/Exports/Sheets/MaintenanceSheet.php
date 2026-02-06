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

class MaintenanceSheet implements FromArray, WithTitle, WithStyles
{
    public function array(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Get all maintenance for the month
        $maintenanceItems = Maintenance::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        // Dashboard counts
        $totalScheduled = $maintenanceItems->count();
        $totalCompleted = $maintenanceItems->whereNotNull('completed_at')->count();

        $rows = [];

        // Dashboard row (spanning multiple columns)
        $rows[] = ['Maintenance Dashboard'];
        $rows[] = [
            'Total Scheduled Maintenance',
            $totalScheduled,
            'Total Completed Maintenance',
            $totalCompleted
        ];

        // Header for maintenance details (immediately after dashboard)
        $rows[] = [
            'Maintenance Type',
            'Asset Tag',
            'Asset Name',
            'Issue Description',
            'Action Taken',
            'Start Date',
            'Completion Date'
        ];

        // Maintenance details
        foreach ($maintenanceItems as $m) {
            $rows[] = [
                $m->maintenance_type,
                $m->asset_tag ?? 'N/A',
                $m->asset_name ?? 'N/A',
                $m->description,
                $m->post_description,
                $m->start_date ? Carbon::parse($m->start_date)->format('M d, Y') : null,
                $m->completed_at ? Carbon::parse($m->completed_at)->format('M d, Y') : null,
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
                'startColor' => ['argb' => 'FFCCE5FF'],
            ],
        ]);

        // Dashboard counts (row 2)
        $sheet->getStyle('A2:D2')->applyFromArray([
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
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFCCE5FF'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Data rows (row 4 to last)
        $sheet->getStyle("A4:G{$highestRow}")->applyFromArray([
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
