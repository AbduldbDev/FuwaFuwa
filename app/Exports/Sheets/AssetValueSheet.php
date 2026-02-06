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
use Carbon\Carbon;

class AssetValueSheet implements FromArray, WithTitle, WithStyles
{
    protected $limit;

    public function __construct($limit = 100)
    {
        $this->limit = $limit;
    }

    public function array(): array
    {
        $assets = Assets::where('operational_status', '!=', 'Archived')
            ->latest('updated_at')
            ->take($this->limit)
            ->get();

        $rows = [];

        // Header row
        $rows[] = [
            'Asset Tag',
            'Asset Name',
            'Asset Type',
            'Purchase Cost (₱)',
            'Salvage Value (₱)',
            'Useful Life (Years)',
            'Years Used',
            'Depreciation Expense (₱)',
            'Remaining Life',
            'Depreciation Rate (%)',
            'Current Value (₱)'
        ];

        foreach ($assets as $asset) {
            if ($asset->asset_type === 'Digital Asset') {
                $asset->depreciation_expense = 0;
                $asset->current_value = 0;
                $asset->years_used = 0;
                $asset->remaining_life = $asset->useful_life_years ?? 0;
                $asset->depreciation_rate = 0;
            } else {
                $cost = $asset->purchase_cost ?? 0;
                $salvage = $asset->salvage_value ?? 0;
                $usefulLife = $asset->useful_life_years ?? 1;

                $purchaseDate = $asset->purchase_date instanceof Carbon ? $asset->purchase_date : Carbon::parse($asset->purchase_date);
                $yearsUsed = $purchaseDate->diffInYears(now());
                $depreciation = ($cost - $salvage) / $usefulLife;
                $totalDepreciation = $depreciation * $yearsUsed;
                $currentValue = max($cost - $totalDepreciation, $salvage);

                $asset->depreciation_expense = $depreciation;
                $asset->current_value = $currentValue;
                $asset->years_used = $yearsUsed;
                $asset->remaining_life = max($usefulLife - $yearsUsed, 0);
                $asset->depreciation_rate = (($cost - $salvage) / $cost / $usefulLife) * 100;
            }

            $rows[] = [
                $asset->asset_tag,
                $asset->asset_name,
                $asset->asset_type,
                '₱' . number_format($asset->purchase_cost ?? 0, 2),
                '₱' . number_format($asset->salvage_value ?? 0, 2),
                number_format($asset->useful_life_years ?? 0, 2),
                number_format($asset->years_used, 2),
                '₱' . number_format($asset->depreciation_expense, 2),
                number_format($asset->remaining_life, 2),
                number_format($asset->depreciation_rate, 2) . '%',
                '₱' . number_format($asset->current_value, 2),
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Asset Value';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header style
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
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

        // Data rows style
        $sheet->getStyle("A2:{$highestColumn}{$highestRow}")->applyFromArray([
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
            $maxWidth = 30;
            if ($sheet->getColumnDimension($col)->getWidth() > $maxWidth) {
                $sheet->getColumnDimension($col)->setWidth($maxWidth);
            }
        }

        return [];
    }
}
