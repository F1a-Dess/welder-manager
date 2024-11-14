<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;

class DailyAttitudeExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $students;
    protected $selectedDate;
    protected $typeWeldFilter;

    public function __construct($students, $selectedDate, $typeWeldFilter = [])
    {
        $this->students = $students;
        $this->selectedDate = $selectedDate;
        $this->typeWeldFilter = $typeWeldFilter;
    }

    public function collection()
    {
        $exportData = [];

        foreach ($this->students->sortBy('no_test') as $index => $student) {
            // Get scores for the selected date
            $scores = $student->scores->where('date', $this->selectedDate);


            foreach ($scores as $score) {
                $rowIndex = count($exportData) + 3; // Adjust for Excel row (start from 3 due to headers)
                $totalFormula = "=SUM(D{$rowIndex}:F{$rowIndex})";

                $exportData[] = [
                    'No' => $index + 1,
                    'No Test' => $student->no_test,
                    'Name' => $student->name,
                    'rci' => $score->rci,
                    'opa' => $score->opa,
                    'ncd' => $score->ncd,
                    'Total' => $totalFormula, // Excel formula for the Total column
                ];
            }
        }


        return collect($exportData);
    }
    
    public function headings(): array
    {
        return [
            ['Daily Attitude Report for ' . Carbon::parse($this->selectedDate)->format('Y-m-d')],
            ['No', 'No Test', 'Name', 'Responsibility', 'Obedience', 'Neatness', 'Total',],
        ];
    }

    public function title(): string
    {
        return 'Daily Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Basic styling
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A2:G2')->getFont()->setBold(true);

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Merge the title cell
        $sheet->mergeCells('A1:G1');

        // Center-align the title
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Align header columns
        $sheet->getStyle('A2:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Apply borders to the entire table
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $tableRange = "A2:{$highestColumn}{$highestRow}";

        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->getColor()->setRGB('2b2b2b');
    }

}
