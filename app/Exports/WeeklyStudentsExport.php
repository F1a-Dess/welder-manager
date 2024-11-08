<?php

namespace App\Exports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;

class WeeklyStudentsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $students;
    protected $endDate;

    // Constructor to pass the data from the controller
    public function __construct($students, $endDate) {
        
        $this->students = $students;
        $this->endDate = $endDate;
    }

    // Define the headings for the spreadsheet
    public function headings(): array {

        $formattedDate = Carbon::parse($this->endDate)->format('Y.m.d');
        return [
            ['WEEKLY REPORT ASSESSMENT ' . $formattedDate]
        ];
    }

    // Prepare the data as an array for export
    public function collection() {
        $exportData = [];

        // big title
        $exportData[] = ['']; // Empty row after the title
        $currentRow = 4; // Start track from 2rd row
        
        foreach ($this->students as $student) {
            $exportData[] = ["FULL NAME: {$student->no_test} - {$student->name}", ""];
            $exportData[] = ['No', 'Day', 'Date', 'Welding Skill', 'Language', 'Attitude', 'Total', 'Grade', 'Type Welding'];
            $currentRow++;

            foreach ($student->scores as $index => $score) {
                $rowNumber = $currentRow; // track current row

                $exportData[] = [
                    $index + 1,
                    Carbon::parse($score->date)->format('l'), // Day of the week
                    $score->date,
                    $score->welding_skill,
                    $score->language,
                    $score->attitude,
                    // Excel formula to sum welding skill, language, and attitude
                    "=SUM(D{$rowNumber}:F{$rowNumber})",
                    $score->grade,
                    $score->type_weld,
                ];

                $currentRow++;
            }

            $exportData[] = ['']; // Empty row between students
            $currentRow++;
            $currentRow++;
        }

        return collect($exportData);
    }

    public function title(): string {
        return 'Sheet 1';
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet) {
        // Merge the title row (A1:H1)
        $sheet->mergeCells('A1:H1');

        // Start from row 2
        $row = 2;

        foreach($this->students as $student) {
            $sheet->mergeCells("A{$row}:B{$row}");
            $row += count($student->scores) + 3;
        }

        // Set the title row to bold, centered, and larger font size
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
