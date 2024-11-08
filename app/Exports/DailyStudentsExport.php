<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class DailyStudentsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $students;
    protected $selectedDate;

    public function __construct($students, $selectedDate)
    {
        $this->students = $students;
        $this->selectedDate = $selectedDate;
    }

    public function collection()
    {
        $exportData = [];
        $sortedStudents = $this->students->sortBy('no_test');

        // R1
        /* 
        foreach ($this->students as $index => $student) {
            $score = $student->scores->first();

            $exportData[] = [
                $index + 1,
                $student->no_test,
                $student->name,
                
                $score ? $score->UC : '',
                $score ? $score->OV : '',
                $score ? $score->PO : '',
                $score ? $score->UFVi : '',
                $score ? $score->root_visual : '',
                $this->calculateTotal($score)
            ];
        }
        */

        // R2
        foreach ($sortedStudents as $index => $student) {
            // Fetch scores based on type_weld
            $score3G = $student->scores->where('type_weld', '3G')->first();
            $score4G = $student->scores->where('type_weld', '4G')->first();
            
            // Constrct a row for the export data
            $exportData[] = [
                $index + 1,
                $student->no_test,
                $student->name,

                // 3G Position Data
                $score3G ? $score3G->UC : '',
                $score3G ? $score3G->OV : '',
                $score3G ? $score3G->PO : '',
                $score3G ? $score3G->UFVi : '',
                $score3G ? $score3G->root_visual : '',
                $this->calculateTotal($score3G),
                // 4G Position Data
                $score4G ? $score4G->UC : '',
                $score4G ? $score4G->OV : '',
                $score4G ? $score4G->PO : '',
                $score4G ? $score4G->UFVi : '',
                $score4G ? $score4G->root_visual : '',
                $this->calculateTotal($score4G),

            ];
        }


        return collect($exportData);
    }
    
    public function headings(): array
    {
        return [
            ['Daily Report for ' . Carbon::parse($this->selectedDate)->format('Y-m-d')],
            [
                'No', 'No Test', 'Name',
                '3G POSITION', '', '', '', '', 'Total',
                '4G POSITION', '', '', '', '', 'Total'
            ],
            [
                '', '', '',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Root Visual', '',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Tack Weld', ''
            ]
        ];
    }

    public function title(): string
    {
        return 'Daily Report';
    }

    public function styles(Worksheet $sheet)
    {
        // R1
        /*
        // Custom styles for the daily report
        // Apply some basic styling
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A2:J2')->getFont()->setBold(true);
        
        // Auto-size columns
        foreach(range('A','J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Merge the title cell
        $sheet->mergeCells('A1:J1');
        
        // Center align the title
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        */

        // R2
        // Apply bold font to headings
        $sheet->getStyle('A1:O3')->getFont()->setBold(true);

        // Merge title cell and align center
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge headers for 3G and 4G POSITION and align them center
        $sheet->mergeCells('D2:H2');
        $sheet->mergeCells('J2:N2');
        $sheet->getStyle('D2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:N2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Apply borders to the entire data area for clarity
        $sheet->getStyle('A3:O' . ($this->students->count() + 3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Auto-size all columns
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function calculateTotal($score)
    {
        // Sum up UC, OV, PO, UFVi, root_visual fields here
        if (!$score) {
            return 0;
        }

        return array_sum([
            $score->UC ?? 0,
            $score->OV ?? 0,
            $score->PO ?? 0,
            $score->UFVi ?? 0,
            $score->root_visual ?? 0
        ]);
    }
}
