<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentScoreResource;
use App\Models\Student;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentScoreController extends Controller
{
    public function index()
    {
        $scores = StudentScore::with('student')->get();
        return response()->json($scores);
    }


    public function store(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'welding_skill' => 'required|integer',
            'language' => 'required|integer',
            'attitude' => 'required|integer',
            'total_score' => 'required|integer',
            'grade' => 'required|string|max:16',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandetory',
                'error' => $validator->messages()
            ], 422);
        }

        $totalScore = $request->welding_skill + $request->language + $request->attitude;

        $score = $student->scores()->create([
            'student_id' => $request->student_id,
            'date' => $request->date,
            'welding_skill' => $request->welding_skill,
            'language' => $request->language,
            'attitude' => $request->attitude,
            'total_score' => $totalScore,
            'grade' => $request->grade
            
        ]);



        return response()->json([
            'message'=> 'Student Score Created Succesfully',
            'data'=> new StudentScoreResource($score)
        ],201);
    }

    public function show($id)
{
    $student = Student::with('scores')->findOrFail($id);
    return response()->json([
        'student' => $student
    ]);
}


    // Update a student score
    public function update(Request $request, StudentScore $studentScore) {
        
        $validatedData = $request->validate([
            'date' => 'required|date',
            'welding_skill' => 'required|numeric',
            'language' => 'required|numeric',
            'attitude' => 'required|numeric',
            'grade' => 'required|string|max:1'
        ]);

        // Calculate total score
        $total_score = $validatedData['welding_skill'] + $validatedData['language'] + $validatedData['attitude'];

        // Update the score
        $studentScore->update([
            'date' => $request -> date,
            'welding_skill' => $request -> welding_skill,
            'language' => $request ->language,
            'attitude' => $request -> attributes,
            'grade' => $request -> grade,
            'total_score' => $total_score,
        ]);

        return redirect()->route('student-scores.index', $studentScore->student_id)->with('message', 'Score updated successfully!');
    }
    
    public function destroy(Student $student, $id)
    {
        $score = $student->scores()->findOrFail($id);
        $score->delete();

        return response()->json([
            'message'=> 'Student Data Has Deleted Successfully'
        ],204);
    }
}
