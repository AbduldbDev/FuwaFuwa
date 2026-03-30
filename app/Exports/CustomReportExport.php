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

                $value = $item->$column ?? null;

                // Reporter name
                if ($column === 'reported_by') {
                    $value = $item->reporter->name ?? null;
                }
                // Relations ending with _id
                elseif (Str::endsWith($column, '_id')) {
                    $relation = Str::replaceLast('_id', '', $column);
                    $value = $item->$relation->name ?? null;
                }
                // Currency fields
                elseif (in_array($column, ['purchase_cost', 'salvage_value', 'current_value', 'depreciation_expense'])) {
                    $num = $item->$column ?? 0;
                    $value = '₱' . number_format($num, 2);
                }
                // Percent fields
                elseif (in_array($column, ['depreciation_rate'])) {
                    $num = $item->$column ?? 0;
                    $value = number_format($num, 0) . '%';
                }
                // Whole-number fields
                elseif (in_array($column, ['years_used', 'remaining_life'])) {
                    $num = $item->$column ?? 0;
                    $value = (string) (int) $num; // 0.123 → 0, 1.231 → 1
                }
                // Date fields
                elseif (in_array($column, ['purchase_date', 'warranty_start', 'warranty_end', 'last_maintenance', 'next_maintenance', 'last_maintenance_date', 'completed_at', 'start_date', 'created_at', 'updated_at'])) {
                    if ($value) {
                        $value = Carbon::parse($value)->format('M d, Y'); // Jan 20, 2025
                    } else {
                        $value = null;
                    }
                }
                // Technical specifications (textarea, new line based)
                elseif ($column === 'technical_specifications') {
                    $value = $item->$column ?? null;
                }
                // Default columns
                else {
                    $value = $item->$column ?? null;
                }

                // Fallback to "N/A" if empty or null
                if ($value === null || (is_string($value) && trim($value) === '')) {
                    $value = 'N/A';
                }

                $row[$column] = $value;
            }

            return $row;
        });
    }

    public function headings(): array
    {
        return array_map(function ($col) {

            if ($col === 'warranty_status') {
                return 'Under Warranty / Unexpired';
            }

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
