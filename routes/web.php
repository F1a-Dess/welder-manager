<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentScoreController;
use App\Http\Controllers\StudentDataExportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('aboutUs');
Route::inertia('/contact', 'Frontend/Contact')->name('contact');

Route::resource('students', StudentController::class);
Route::resource('student-scores', StudentScoreController::class);

Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
Route::get('students/{student}/create-score', [StudentScoreController::class, 'create'])->name('students.create-score');
// Route::get('students/{student}/update-score', [StudentScoreController::class, 'edit'])->name('students.update-score');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/export-students-scores', [StudentDataExportController::class, 'export'])->name('students-scores.export');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';