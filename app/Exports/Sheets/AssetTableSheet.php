<?php

namespace App\Exports\Sheets;

use App\Models\Assets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AssetTableSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $now = \Carbon\Carbon::now();
        return Assets::with(['technicalSpecifications', 'logs.user'])
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->get()
            ->map(function ($asset) {
                // Format technical specifications
                $techSpecs = $asset->technicalSpecifications
                    ->map(fn($spec) => ucwords(str_replace('_', ' ', $spec->spec_key)) . ': ' . $spec->spec_value)
                    ->implode("\n");

                // Format asset logs
                $logs = $asset->logs
                    ->map(fn($log) => "{$log->user->name} | {$log->action} | {$log->field_name}: '{$log->old_value}' → '{$log->new_value}'")
                    ->implode("\n");

                return [
                    $asset->asset_tag,
                    $asset->asset_name,
                    $asset->asset_category,
                    $asset->asset_type,
                    $techSpecs,
                    $asset->purchase_cost,
                    $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('M d, Y') : null,
                    $asset->compliance_status,
                    $logs ?: 'No logs',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Asset Tag',
            'Asset Name',
            'Asset Category',
            'Asset Type',
            'Technical Specification',
            'Purchase Cost',
            'Purchase Date',
            'Compliance Status',
            'Asset Logs',
        ];
    }

    public function title(): string
    {
        return 'Newly Registered Assets';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header style
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'fdb38e'],
            ],
        ]);

        // All cells borders + centered text
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
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
            $maxWidth = 50; // allow wider columns for logs/specs
            if ($sheet->getColumnDimension($col)->getWidth() > $maxWidth) {
                $sheet->getColumnDimension($col)->setWidth($maxWidth);
            }
        }

        // Format Purchase Date column (G)
        $sheet->getStyle('G2:G' . $highestRow)
            ->getNumberFormat()
            ->setFormatCode('mmm dd, yyyy');

        return [];
    }
}
