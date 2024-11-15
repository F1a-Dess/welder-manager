<?php

namespace App\Http\Controllers;

use App\Models\Student;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(50);
        return Inertia::render("Frontend/Student/indexStudent",[
            "students"=> $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Frontend/Student/createStudent");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            "name"=> "required|string|max:255",
            "wave"=> "nullable|integer",
            "no_test"=> "nullable|string|max:255",
        ]);

        Student::create([
            "name"=> $request -> name,
            "wave"=> $request -> wave ?? null,
            "no_test"=> $request -> no_test ?? null,
        ]);

        return redirect()->to("/students")->with("message","Student Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::with('scores')->findOrFail($id);
        return Inertia::render("Frontend/Student/showStudent", [
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return Inertia::render("Frontend/Student/editStudent", [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request ->validate([
            "name"=> "required|string|max:255",
            "wave"=> "nullable|integer",
            "no_test"=> "nullable|string|max:255",
        ]);

        $student->update([
            "name"=> $request -> name,
            "wave"=> $request -> wave ?? null,
            "no_test"=> $request -> no_test ?? null,
        ]);

        return redirect()->to("/students")->with("message","Student Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->scores()->delete();
        $student->delete();
        return redirect()->to("/students")->with("message","Student deleted successfully");
    }
}
