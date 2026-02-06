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


class ArchivedAssetsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $now = \Carbon\Carbon::now();
        return Assets::where('operational_status', 'archived')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->get()
            ->map(function ($asset) {
                return [
                    $asset->asset_tag,
                    $asset->asset_name,
                    $asset->asset_category,
                    $asset->asset_type,
                    $asset->technicalSpecifications
                        ->map(fn($spec) => ucwords(str_replace('_', ' ', $spec->spec_key)) . ': ' . $spec->spec_value)
                        ->implode("\n"),
                    $asset->compliance_status,
                    $asset->delete_title,
                    $asset->delete_reason,
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
            'Compliance Status',
            'Archive Status',
            'Archive Reason',
        ];
    }

    public function title(): string
    {
        return 'Archived Assets';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header style (bold, fill, borders, centered)
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
                'wrapText' => true, // optional, wraps text if too long
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
            $maxWidth = 40;
            if ($sheet->getColumnDimension($col)->getWidth() > $maxWidth) {
                $sheet->getColumnDimension($col)->setWidth($maxWidth);
            }
        }

        // Date formatting (Purchase Date column, adjust column letter)
        $sheet->getStyle('G2:G' . $highestRow)
            ->getNumberFormat()
            ->setFormatCode('mmm dd, yyyy');

        return [];
    }
}
