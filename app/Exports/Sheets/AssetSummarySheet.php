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

class AssetSummarySheet implements FromArray, WithTitle, WithStyles
{
    public function array(): array
    {
        $totalAssets = Assets::count() ?: 0;
        $totalPhysical = Assets::where('asset_type', 'Physical Asset')->count() ?: 0;
        $totalDigital = Assets::where('asset_type', 'Digital Asset')->count() ?: 0;

        return [
            ['All Assets', 'Physical Assets', 'Digital Assets'], // Titles
            [$totalAssets, $totalPhysical,   $totalDigital],       // Data
        ];
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();   // Should be 2
        $highestColumn = $sheet->getHighestColumn(); // Should be C

        // Header (row 1) style
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
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

        // Data row (row 2) style
        $sheet->getStyle("A2:{$highestColumn}2")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20, // dashboard-style big numbers
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

        // Auto-size columns but limit max width
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $maxWidth = 30;
            if ($sheet->getColumnDimension($col)->getWidth() > $maxWidth) {
                $sheet->getColumnDimension($col)->setWidth($maxWidth);
            }
        }

        return [];
    }
}
