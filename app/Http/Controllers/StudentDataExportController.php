<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StudentDataExportController extends Controller
{
    public function export(Request $request)
    {
        $validated = $request->validate([
            'selectedStudents' => 'required|array',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
    
        // Fetch students with their scores sorted by date
        $students = Student::with(['scores' => function ($query) use ($validated) {
            $query->whereBetween('date', [$validated['startDate'], $validated['endDate']])
                  ->orderBy('date', 'asc'); // Ensure scores are sorted by date
        }])->whereIn('id', $validated['selectedStudents'])->get();
    
        // Format the end date correctly for the filename
        $formattedEndDate = Carbon::parse($validated['endDate'])->format('Y m d');
        // $formattedEndDate = Carbon::parse($validated['endDate']);
        Log::info('Formatted End Date: ' . $formattedEndDate);
    
        // Trim any extra spaces and correctly concatenate the filename
        $fileName = "{$formattedEndDate} WEEKLY REPORT ASSESSMENT.xlsx";
        $encodedFileName =rawurldecode($fileName);

        Log::info('Generated filename: ' . $encodedFileName);

        // Use the custom export class and download the file
        return Excel::download( new StudentsExport($students), $encodedFileName);
        
        // return Excel::download(
        //     new StudentsExport($students),
        //     $fileName,
        //     \Maatwebsite\Excel\Excel::XLSX,
        //     [
        //         'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //         'Content-Disposition' => "attachment; filename*=UTF-8''" . $encodedFileName
        //     ]
        //     );

        // return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(true);
    }

}
