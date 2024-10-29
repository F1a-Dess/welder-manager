<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StudentScoreController;
use App\Http\Controllers\StudentDataExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('students', StudentController::class);
Route::apiResource('student-scores', StudentScoreController::class);

Route::post('students/{student}/scores',[StudentScoreController::class,'store']);
// Route::put('students/{student}/scores/{score}', [StudentScoreController::class, 'update']);
// Route::put('student-scores/{student_score}', [StudentScoreController::class, 'update'])->name('student-scores.update');
Route::delete('students/{student}/scores/{score}', [StudentScoreController::class, 'destroy']);

// Route::get('/students/{student}/scores/{score}/edit', [StudentScoreController::class, 'edit'])->name('students.update-score');

Route::get('students/{student}/create-score', [StudentScoreController::class, 'create'])->name('students.create-score');
Route::post('students/{student}/scores', [StudentScoreController::class, 'store'])->name('students.scores.store');


// export Route
Route::post('/export-students-scores', [StudentDataExportController::class, 'export'])->name('students-scores.export');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
