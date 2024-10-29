<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Promise\Create;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        
        // laravel full stacks
    
        $student = Student::get();
        if($student->count() > 0) {
            return StudentResource::collection($student);
        } else {
            return response()->json(['massage' => 'No record available'], 200); 
        } 

       
    }

    public function store(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'wave'=> 'nullable|integer',
            'no_test'=> 'nullable|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandetory',
                'error' => $validator->messages()
            ], 422);
        }

        $student = Student::create([
            'name'=> $request->name,
            'wave'=> $request->wave ?? null,
            'no_test'=> $request->no_test ?? null,
        ]);

        return response()->json([
            'message'=> 'Student Data Created Succesfully',
            'data'=> new StudentResource($student)
        ],200);
    }

    public function show(Student $student, $id) {
        $student = Student::with('scores')->findOrFail($id);
        return new StudentResource($student);

    }

    public function update( Request $request, Student $student) {
        
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'wave'=> 'nullable|integer',
            'no_test'=> 'nullable|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandetory',
                'error' => $validator->messages()
            ], 422);
        }

        $student -> update([
            'name'=> $request->name,
            'wave'=> $request->wave ?? null,
            'no_test'=> $request->no_test ?? null,
        ]);

        return response()->json([
            'message'=> 'Student Data Updated Successfully',
            'data'=> new StudentResource($student)
        ],200);
    }

    public function destroy(Student $student) {
        $student->delete();
        return response()->json([
            'message'=> 'Student Data Has Deleted Successfully'
        ],200);
    }
}
