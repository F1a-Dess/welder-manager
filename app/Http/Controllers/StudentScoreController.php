<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class StudentScoreController extends Controller
{

    public function index(Student $student)
    {
        $student_scores = StudentScore::paginate(10);
        return Inertia::render("Frontend/Student/showStudent",[
            "score"=> $student_scores,
            "student" => $student->load('scores')
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

            // language 
            "class_prep" => "required|integer",
            "understanding" => "required|integer",
            "conversation" => "required|integer",
            "vocabulary" => "required|integer",
            "weekly" => "required|integer",
            "k_song" => "required|integer",
            
            // attitude
            "rci" => "required|integer",
            "opa" => "required|integer",
            "ncd" => "required|integer",
            
            // welding
            "UC" => 'required|integer',
            "OV" => 'required|integer',
            "PO" => 'required|integer',
            "UFVi" => 'required|integer',
            "root_visual" => 'required|integer',
            
            // summary
            "language" => 'required|integer', // sum of language details
            "attitude" => 'required|integer', // sum of attitude
            'welding_skill' => 'required|integer',

            "grade" => 'required|string|max:1',
            "type_weld" => 'required|string|in:3G 12T,3G 20T,4G 12T,4G 20T',
            // "type_weld" => 'required|string|in:3G_12T,3G_20T,4G_12T,4G_20T',
        ]);

        // calculate all
        $welding_skill = $validatedData['UC'] + $validatedData['OV'] + $validatedData['PO'] + $validatedData['UFVi'] + $validatedData['root_visual'];
        $language = 
            $validatedData['class_prep'] + $validatedData['understanding'] + $validatedData['conversation'] + 
            $validatedData['vocabulary'] + $validatedData['weekly'] + $validatedData['k_song'];
        $attitude = $validatedData['rci'] + $validatedData['opa'] + $validatedData['ncd'];
        $total_score = $welding_skill + $language + $attitude;

        // save new score
        $student = Student::findOrFail($validatedData['student_id']);
        $student->scores()->create([
            'student_id'=> $request->student_id,
            'date' => $request -> date,

            // language
            'language'=>$language, // sum language
            'class_prep'=> $request-> class_prep,
            'understanding'=> $request-> understanding,
            'conversation'=> $request-> conversation,
            'vocabulary'=> $request-> vocabulary,
            'weekly'=> $request-> weekly,
            'k_song'=> $request-> k_song,
            
            // attitude
            'attitude'=> $attitude, // sum attitude
            'rci'=> $request-> rci,
            'opa'=> $request-> opa,
            'ncd'=> $request-> ncd,
            
            // welding
            'welding_skill'=>$welding_skill,
            'UC'=> $request-> UC,
            'OV'=> $request-> OV,
            'PO'=> $request-> PO,
            'UFVi'=> $request-> UFVi,
            'root_visual'=> $request-> root_visual,
            
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
            'date'=> 'required|date',

            // language 
            "class_prep" => "required|integer",
            "understanding" => "required|integer",
            "conversation" => "required|integer",
            "vocabulary" => "required|integer",
            "weekly" => "required|integer",
            "k_song" => "required|integer",
            
            // attitude
            "rci" => "required|integer",
            "opa" => "required|integer",
            "ncd" => "required|integer",
            
            // welding
            "UC" => 'required|integer',
            "OV" => 'required|integer',
            "PO" => 'required|integer',
            "UFVi" => 'required|integer',
            "root_visual" => 'required|integer',
            
            // summary
            "language" => 'required|integer', // sum of language details
            "attitude" => 'required|integer', // sum of attitude
            'welding_skill' => 'required|integer',

            "grade" => 'required|string|max:1',
            "type_weld" => 'required|string|in:3G 12T,3G 20T,4G 12T,4G 20T',
        ]);

        // Calculate all
        $welding_skill = $validatedData['UC'] + $validatedData['OV'] + $validatedData['PO'] + $validatedData['UFVi'] + $validatedData['root_visual'];
        $language = 
            $validatedData['class_prep'] + $validatedData['understanding'] + $validatedData['conversation'] + 
            $validatedData['vocabulary'] + $validatedData['weekly'] + $validatedData['k_song'];
        $attitude = $validatedData['rci'] + $validatedData['opa'] + $validatedData['ncd'];
        $total_score = $welding_skill + $language + $attitude;

        // Update the score
        $student_score->update([
            'student_id'=> $request->student_id,
            'date' => $request -> date,

            // language
            'language'=>$language, // sum language
            'class_prep'=> $request-> class_prep,
            'understanding'=> $request-> understanding,
            'conversation'=> $request-> conversation,
            'vocabulary'=> $request-> vocabulary,
            'weekly'=> $request-> weekly,
            'k_song'=> $request-> k_song,
            
            // attitude
            'attitude'=> $attitude, // sum attitude
            'rci'=> $request-> rci,
            'opa'=> $request-> opa,
            'ncd'=> $request-> ncd,
            
            // welding
            'welding_skill'=>$welding_skill,
            'UC'=> $request-> UC,
            'OV'=> $request-> OV,
            'PO'=> $request-> PO,
            'UFVi'=> $request-> UFVi,
            'root_visual'=> $request-> root_visual,
            
            'total_score'=>$total_score,
            'grade' => $request -> grade,
            'type_weld' => $request -> type_weld,
        ]);

        return redirect()->route('student-scores.index', $student_score->student_id)->with('message', 'Score updated successfully!');
    }

    public function destroy(StudentScore $student_score)
    {        
        $student_score->delete();

        // return redirect()->route('student-scores.index', $student_score->student_id)->with('message', 'Score deleted successfully!');
        // return response()->json(['message' => 'Score deleted successfully!']);
        return redirect()->back()->with('message', 'Score deleted successfully!');
    }
    
    public function boot(Student $student): void
    {
        Model::preventSilentlyDiscardingAttributes($this->$student->isLocal());
    }
}
