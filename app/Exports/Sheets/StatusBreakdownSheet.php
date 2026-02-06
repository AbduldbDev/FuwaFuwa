<?php

namespace App\Exports\Sheets;

use App\Models\Assets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StatusBreakdownSheet implements FromArray, WithTitle, WithStyles
{
    public function array(): array
    {
        $statuses = ['Active', 'In Stock', 'Under Maintenance', 'Archived'];

        $rows = [];

        // Header row
        $rows[] = array_merge(['Asset Type'], $statuses);

        // Types of assets
        $types = [
            'All Assets' => null, // null means all
            'Physical Assets' => 'Physical Asset',
            'Digital Assets' => 'Digital Asset',
        ];

        foreach ($types as $label => $type) {
            $row = [$label];
            foreach ($statuses as $status) {
                $countQuery = Assets::query();
                if ($type) {
                    $countQuery->where('asset_type', $type);
                }
                $count = $countQuery->where('operational_status', $status)->count();
                $row[] = $count ?: 0;
            }
            $rows[] = $row;
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Status Breakdown';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header style
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'fdb38e'], // light blue
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Data rows style
        $sheet->getStyle("A2:{$highestColumn}{$highestRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
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

        // Auto-size columns
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
