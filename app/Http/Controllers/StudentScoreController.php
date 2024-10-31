<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class StudentScoreController extends Controller
{

    public function index()
    {
        $student_scores = StudentScore::paginate(10);
        return Inertia::render("Frontend/Student/showStudent",[
            "score"=> $student_scores
        ]);
    }



    public function create(Student $student) {

        return Inertia::render("Frontend/Score/createStudentScore", [
            'student' => $student
        ]);
    }

    public function show($id) {

        $student = Student::with('scores')->findOrFail($id);
        return Inertia::render("Frontend/Student/showStudent", [
            'student' => $student,
        ]);

    }

    // Edit a student score
    public function edit(StudentScore $student_score) {

        $student = $student_score->student; // Load the related student

        return Inertia::render("Frontend/Score/editStudentScore", [
            'score' => $student_score,
            'student' => $student
        ]);
    }


    public function store(Request $request, Student $student) {

        // validate requested data
        $validatedData = $request->validate([
            
            'student_id' => 'required|exists:students,id',
            'date'=> 'required|date',
            'welding_skill' => 'required|integer',
            "language" => 'required|integer',
            "attitude" => 'required|integer',
            "grade" => 'required|string|max:1',
            "type_weld" => 'required|string|in:3G,4G',
        ]);

        // calculate total score
        $total_score = $validatedData['welding_skill'] + $validatedData['language'] + $validatedData['attitude'];

        // save new score
        $student = Student::findOrFail($validatedData['student_id']);
        $student->scores()->create([
            'student_id'=> $request->student_id,
            'date' => $request -> date,
            'welding_skill' => $request -> welding_skill,
            'language'=> $request -> language,
            'attitude'=> $request -> attitude,
            'total_score'=>$total_score,
            'grade' => $request -> grade,
            'type_weld' => $request -> type_weld,
        ]);

        // return response()->json($score, 201);
        return redirect()->route('students.show', $student->id)->with('message', 'Score added successfully');
        
    }

    // Update a student score
    public function update(Request $request, StudentScore $student_score) {
        
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'welding_skill' => 'required|integer',
            'language' => 'required|integer',
            'attitude' => 'required|integer',
            'grade' => 'required|string|max:1',
            "type_weld" => 'required|string|in:3G,4G',
        ]);

        // Calculate total score
        $total_score = $validatedData['welding_skill'] + $validatedData['language'] + $validatedData['attitude'];

        // Update the score
        $student_score->update([
            'student_id'=> $request->student_id,
            'date' => $request -> date,
            'welding_skill' => $request -> welding_skill,
            'language' => $request ->language,
            'attitude' => $request -> attitude,
            'grade' => $request -> grade,
            'type_weld' => $request -> type_weld,
            'total_score' => $total_score,
        ]);

        return redirect()->route('student-scores.index', $student_score->student_id)->with('message', 'Score updated successfully!');
    }

    public function destroy(StudentScore $studentScore)
    {
        $studentScore->delete();

        return redirect()->route('student-scores.index', $studentScore->student_id)->with('message', 'Score deleted successfully!');
    }
    
    public function boot(Student $student): void
    {
        Model::preventSilentlyDiscardingAttributes($this->$student->isLocal());
    }
}
