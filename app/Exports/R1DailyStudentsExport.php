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

class R1DailyStudentsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
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
            $score3G12T = $student->scores->where('type_weld', '3G 12T')->first();
            $score3G20T = $student->scores->where('type_weld', '3G 20T')->first();
            $score4G12T = $student->scores->where('type_weld', '4G 12T')->first();
            $score4G20T = $student->scores->where('type_weld', '4G 20T')->first();
            
            // Constrct a row for the export data
            $exportData[] = [
                $index + 1,
                $student->no_test,
                $student->name,

                // 3G 12T Position Data
                $score3G12T ? $score3G12T->UC : '',
                $score3G12T ? $score3G12T->OV : '',
                $score3G12T ? $score3G12T->PO : '',
                $score3G12T ? $score3G12T->UFVi : '',
                $score3G12T ? $score3G12T->root_visual : '',
                $this->calculateTotal($score3G12T),
                // 3G 20TPosition Data
                $score3G20T ? $score3G20T->UC : '',
                $score3G20T ? $score3G20T->OV : '',
                $score3G20T ? $score3G20T->PO : '',
                $score3G20T ? $score3G20T->UFVi : '',
                $score3G20T ? $score3G20T->root_visual : '',
                $this->calculateTotal($score3G20T),
                
                // 4G 12T Position Data
                $score4G12T ? $score4G12T->UC : '',
                $score4G12T ? $score4G12T->OV : '',
                $score4G12T ? $score4G12T->PO : '',
                $score4G12T ? $score4G12T->UFVi : '',
                $score4G12T ? $score4G12T->root_visual : '',
                $this->calculateTotal($score4G12T),
                // 4G 20T Position Data
                $score4G20T ? $score4G20T->UC : '',
                $score4G20T ? $score4G20T->OV : '',
                $score4G20T ? $score4G20T->PO : '',
                $score4G20T ? $score4G20T->UFVi : '',
                $score4G20T ? $score4G20T->root_visual : '',
                $this->calculateTotal($score4G20T),

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
                '3G 12T POSITION', '', '', '', '', '',
                '3G 20T POSITION', '', '', '', '', '',
                '4G 12T POSITION', '', '', '', '', '',
                '4G 20T POSITION', '', '', '', '', '',
            ],
            [
                '', '', '',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Root Visual', 'total',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Root Visual', 'total',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Tack Weld', 'total',
                'U/C', 'OV', 'PO', 'U/F Vi', 'Tack Weld', 'total',
            ]
        ];
    }

    public function title(): string
    {
        return 'Daily Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font to headings
        $sheet->getStyle('A1:AA3')->getFont()->setBold(true);

        // Merge title cell and align center
        $sheet->mergeCells('A1:AA1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge headers for 3G and 4G POSITION and align them center
        $sheet->mergeCells('D2:I2');
        $sheet->mergeCells('J2:O2');
        $sheet->mergeCells('P2:U2');
        $sheet->mergeCells('V2:AA2');    
        $sheet->getStyle('D2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:O2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P2:U2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('V2:AA2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Apply borders to the entire data area for clarity
        $sheet->getStyle('A3:AA' . ($this->students->count() + 3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Auto-size all columns
        foreach (range('A', 'AA') as $col) {
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
