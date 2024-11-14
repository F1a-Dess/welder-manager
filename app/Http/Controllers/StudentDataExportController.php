<?php

namespace App\Http\Controllers;

// use App\Exports\StudentsExport;
use App\Exports\WeeklyStudentsExport;
use App\Exports\DailyStudentsExport;
use App\Exports\DailyLanguageExport;
use App\Exports\DailyAttitudeExport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Symfony\Contracts\Service\Attribute\Required;

class StudentDataExportController extends Controller
{
    public function exportWeekly(Request $request) {
        
        $validated = $request->validate([
            'selectedStudents' => 'required|array',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'reportType' => 'required|string|in:weekly,dailyWelding,dailyLanguage,dailyAttitude' 
        ]);

        try{

            // Fetch students with their scores sorted by date
            $students = Student::with(['scores' => function ($query) use ($validated) {
                $query->whereBetween('date', [$validated['startDate'], $validated['endDate']])
                      ->orderBy('date', 'asc'); // Ensure scores are sorted by date
            }])->whereIn('id', $validated['selectedStudents'])->get();
        
            // Format the end date correctly for the filename
            $formattedEndDate = Carbon::parse($validated['endDate'])->format('Y_m_d');
            // $formattedEndDate = Carbon::parse($validated['endDate']);
        
            // Trim any extra spaces and correctly concatenate the filename
            // $fileName = "WEEKLY REPORT ASSESSMENT{$formattedEndDate}.xlsx";
            $fileName = "{$validated['reportType']}_REPORT_{$formattedEndDate}.xlsx"; 
            $encodedFileName =rawurldecode($fileName);
    
            Log::info('Generated filename: ' . $encodedFileName);
    
            // Use the custom export class and download the file
            return Excel::download( new WeeklyStudentsExport($students, $validated['endDate']), $fileName);
        } catch (\Exception $e) {
            log::error('Weekly export failed: ' . $e->getMessage());
            return response()->json(['message' => 'Export failed'], 500);
        }
    

    }

    public function exportDaily(Request $request){
        
        $validated = $request->validate([
            'selectedStudents' => 'required|array',
            'selectedDate' => 'required|date',
            'reportType' => 'required|string|in:weekly,dailyWelding,dailyLanguage,dailyAttitude' 
        ]);

        try {
            // Fetch students with their scores only for the specific date
            $date = $validated['selectedDate'];
            $students = Student::with(['scores' => function ($query) use ($date) {
                $query->whereDate('date', $date); // Filter scores for the exact date
            }])->whereIn('id', $validated['selectedStudents'])->get();

            if($students->isEmpty()) {
                return response()->json(['message' => 'No data found for the selected date and students'], 404);
            }
    
            Log::info('Daily export: Students data', $students->toArray());
    
            // Format the date correctly for the filename
            $formattedDate = Carbon::parse($date)->format('Y-m-d');
            $fileName = "DAILY REPORT ASSESSMENT {$formattedDate}.xlsx";
    
            // Use the custom StudentsExport class to export data
            return Excel::download(new DailyStudentsExport($students, $date), $fileName);
        } catch (\Exception $e) {
            Log::error('Daily export failed: ' . $e->getMessage());
            return response()->json(['message' => 'Export failed', 'error' => $e->getMessage()], 500);
        }

    }

    public function exportLanguage(Request $request) {

        $validated = $request->validate([
            'selectedStudents' => 'required|array',
            'selectedDate' => 'required|date',
            'reportType' => 'required|string|in:weekly,dailyWelding,dailyLanguage,dailyAttitude' 
        ]);

        try {
            // Fetch students with their scores only for the specific date
            $date = $validated['selectedDate'];
            $students = Student::with(['scores' => function ($query) use ($date) {
                $query->whereDate('date', $date); // Filter scores for the exact date
            }])->whereIn('id', $validated['selectedStudents'])->get();

            if($students->isEmpty()) {
                return response()->json(['message' => 'No data found for the selected date and students'], 404);
            }
    
            Log::info('Daily export: Students data', $students->toArray());
    
            // Format the date correctly for the filename
            $formattedDate = Carbon::parse($date)->format('Y-m-d');
            $fileName = "DAILY LANGUAGE REPORT ASSESSMENT {$formattedDate}.xlsx";
    
            // Use the custom StudentsExport class to export data
            return Excel::download(new DailyLanguageExport($students, $date), $fileName);
        } catch (\Exception $e) {
            Log::error('Daily export failed: ' . $e->getMessage());
            return response()->json(['message' => 'Export failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function exportAttitude(Request $request) {

        $validated = $request->validate([
            'selectedStudents' => 'required|array',
            'selectedDate' => 'required|date',
            'reportType' => 'required|string|in:weekly,dailyWelding,dailyLanguage,dailyAttitude' 
        ]);

        try {
            // Fetch students with their scores only for the specific date
            $date = $validated['selectedDate'];
            $students = Student::with(['scores' => function ($query) use ($date) {
                $query->whereDate('date', $date); // Filter scores for the exact date
            }])->whereIn('id', $validated['selectedStudents'])->get();

            if($students->isEmpty()) {
                return response()->json(['message' => 'No data found for the selected date and students'], 404);
            }
    
            Log::info('Daily export: Students data', $students->toArray());
    
            // Format the date correctly for the filename
            $formattedDate = Carbon::parse($date)->format('Y-m-d');
            $fileName = "DAILY ATTITUDE REPORT ASSESSMENT {$formattedDate}.xlsx";
    
            // Use the custom StudentsExport class to export data
            return Excel::download(new DailyAttitudeExport($students, $date), $fileName);
        } catch (\Exception $e) {
            Log::error('Daily export failed: ' . $e->getMessage());
            return response()->json(['message' => 'Export failed', 'error' => $e->getMessage()], 500);
        }
    }

}
