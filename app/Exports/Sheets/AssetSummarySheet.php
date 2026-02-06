<?php

namespace App\Exports\Sheets;

use App\Models\Assets;
use Carbon\Carbon;
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
        $rows = [];

        /** ========= SUMMARY ========= */
        $rows[] = ['All Assets', 'Physical Assets', 'Digital Assets'];
        $rows[] = [
            Assets::count(),
            Assets::where('asset_type', 'Physical Asset')->count(),
            Assets::where('asset_type', 'Digital Asset')->count(),
        ];
        $rows[] = [];
        $rows[] = [];

        /** ========= DATA ========= */
        $now = Carbon::now();

        $assets = Assets::with(['technicalSpecifications', 'logs.user'])
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->orderBy('asset_type')
            ->get()
            ->groupBy('asset_type');

        foreach ($assets as $assetType => $items) {
            $rows[] = [$assetType];
            $rows[] = [
                'Asset Tag',
                'Asset Name',
                'Category',
                'Asset Type',
                'Technical Specifications',
                'Purchase Cost',
                'Purchase Date',
                'Compliance Status',
                'Logs',
            ];

            foreach ($items as $asset) {
                $rows[] = [
                    $asset->asset_tag,
                    $asset->asset_name,
                    $asset->asset_category,
                    $asset->asset_type,
                    $asset->technicalSpecifications
                        ->map(fn($s) => ucwords(str_replace('_', ' ', $s->spec_key)) . ': ' . $s->spec_value)
                        ->implode("\n"),
                    $asset->purchase_cost,
                    $asset->purchase_date,
                    $asset->compliance_status,
                    $asset->logs->isNotEmpty()
                        ? $asset->logs
                        ->map(
                            fn($l) =>
                            "{$l->user->name} | {$l->action} | {$l->field_name}: '{$l->old_value}' → '{$l->new_value}'"
                        )->implode("\n")
                        : 'No logs',
                ];
            }

            $rows[] = [];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        /** ========= HEADER ========= */
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FDB38E'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        /** ========= ALL CELLS ========= */
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        /** ========= COLUMN WIDTH ========= */
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            if ($sheet->getColumnDimension($col)->getWidth() > 50) {
                $sheet->getColumnDimension($col)->setWidth(50);
            }
        }

        /** ========= DATE FORMAT ========= */
        $sheet->getStyle("G2:G{$highestRow}")
            ->getNumberFormat()
            ->setFormatCode('mmm dd, yyyy');

        /** ========= ASSET TYPE HEADERS ========= */
        $assetTypeHeaders = ['Physical Asset', 'Digital Asset'];

        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("A{$row}")->getValue();
            if (in_array($cellValue, $assetTypeHeaders)) {
                // Merge entire row
                $sheet->mergeCells("A{$row}:{$highestColumn}{$row}");

                // Apply color + bold + centered + borders
                $sheet->getStyle("A{$row}:{$highestColumn}{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FDB38E'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        }

        return [];
    }
}
