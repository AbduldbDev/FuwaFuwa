<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Assets;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;


class CustomReportExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $columns;

    public function __construct(Collection $data, array $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            $row = [];

            foreach ($this->columns as $column) {

                if ($column === 'reported_by') {
                    $row[$column] = $item->reporter->name ?? '';
                } elseif (Str::endsWith($column, '_id')) {
                    $relation = Str::replaceLast('_id', '', $column);
                    $row[$column] = $item->$relation->name ?? '';
                }
                // Handle technicalSpecifications
                elseif ($column === 'technical_specifications') {
                    $row[$column] = $item->technicalSpecifications
                        ->map(fn($s) => ucwords(str_replace('_', ' ', $s->spec_key)) . ': ' . $s->spec_value)
                        ->implode("\n");
                }
                // Handle money/currency fields
                elseif (in_array($column, ['purchase_cost', 'salvage_value', 'current_value'])) {
                    $value = $item->$column ?? 0;
                    $row[$column] = '₱' . number_format($value, 2);
                }
                // Handle percent fields
                elseif (in_array($column, ['depreciation_rate'])) {
                    $value = $item->$column ?? 0;
                    $row[$column] = number_format($value, 2) . '%';
                }
                // Default columns
                else {
                    $row[$column] = $item->$column ?? '';
                }
            }

            return $row;
        });
    }



    public function headings(): array
    {
        return array_map(function ($col) {
            return ucwords(str_replace('_', ' ', $col));
        }, $this->columns);
    }

    public function title(): string
    {
        return 'Custom Report';
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
