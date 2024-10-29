<?php

namespace App\Exports;

use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;

class StudentsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $students;

    // Constructor to pass the data from the controller
    public function __construct($students) {
        
        $this->students = $students;
    }

    // Define the headings for the spreadsheet
    public function headings(): array {
        return [
            ['WEEKLY REPORT ASSESSMENT ' . now()->format('Y.m.d')]
        ];
    }

    // Prepare the data as an array for export
    public function collection() {
        $exportData = [];

        // big title
        $exportData[] = ['']; // Empty row after the title
        $exportData[] = ['No', 'Day', 'Date', 'Welding Skill', 'Language', 'Attitude', 'Total', 'Grade'];
        $currentRow = 4; // Start track from 2rd row

        foreach ($this->students as $student) {
            $exportData[] = ["FULL NAME: {$student->no_test} - {$student->name}"];
            $currentRow++;

            $sortedScores = $student->scores->sortBy('date');

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
                ];

                $currentRow++;
            }

            $exportData[] = ['']; // Empty row between students
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
