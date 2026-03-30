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
        $assets = Assets::with('maintenances.logs')
            ->where('operational_status', '!=', 'Archived')
            ->latest('updated_at')
            ->take($this->limit)
            ->get();

        $rows = [];

        // Header row
        $rows[] = [
            'Asset Tag',
            'Asset Model',
            'Asset Type',
            'Purchase Cost (₱)',
            'Salvage Value (₱)',
            'Useful Life (Years)',
            'Years Used',
            'Total Maintenance Cost (₱)',
            'Depreciation Expense (₱)',
            'Remaining Life',
            'Depreciation Rate (%)',
            'Current Value (₱)',
        ];

        foreach ($assets as $asset) {

            // DIGITAL ASSETS (NO DEPRECIATION)
            if ($asset->asset_type === 'Digital Asset') {
                $yearsUsed = 0;
                $remainingLife = $asset->useful_life_years ?? 0;
                $totalMaintenanceCost = 0;
                $depreciationExpense = 0;
                $currentValue = 0;
                $depreciationRate = 0;
            } else {
                $cost = $asset->purchase_cost ?? 0;
                $salvage = $asset->salvage_value ?? 0;
                $usefulLife = $asset->useful_life_years ?? 1;

                $purchaseDate = $asset->purchase_date instanceof Carbon
                    ? $asset->purchase_date
                    : Carbon::parse($asset->purchase_date);

                $yearsUsed = $purchaseDate->diffInYears(now());
                $totalMaintenanceCost = 0;
                if ($asset->maintenances) {
                    foreach ($asset->maintenances as $maintenance) {
                        if ($maintenance->logs) {
                            $totalMaintenanceCost += $maintenance->logs->sum(fn($log) => $log->cost ?? 0);
                        }
                    }
                }
                $accumulatedDepreciation = (($cost - $salvage) / $usefulLife) * $yearsUsed;
                $currentValue = max($cost - $accumulatedDepreciation, $salvage);
                $remainingLife = max($usefulLife - $yearsUsed, 0);
                $depreciationExpense = $remainingLife > 0
                    ? ($currentValue + $totalMaintenanceCost) / $remainingLife
                    : 0;
                $depreciationRate = $cost > 0 && $usefulLife > 0
                    ? (($cost - $salvage) / $cost / $usefulLife) * 100
                    : 0;
            }

            $rows[] = [
                $asset->asset_tag,
                $asset->asset_model,
                $asset->asset_type,
                '₱' . number_format($asset->purchase_cost ?? 0, 2),
                '₱' . number_format($asset->salvage_value ?? 0, 2),
                number_format($asset->useful_life_years ?? 0, 0),
                number_format($yearsUsed, 0),
                '₱' . number_format($totalMaintenanceCost, 2),
                '₱' . number_format($depreciationExpense, 2),
                number_format($remainingLife, 0),
                number_format($depreciationRate, 2) . '%',
                '₱' . number_format($currentValue, 2),
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
