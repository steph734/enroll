<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\TrackStrandController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('login.login');
})->name('login');

Route::get('/signup', function () {
    return view('login.signup');
})->name('signup');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('enrollment.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Student routes
    Route::get('/students/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

    // Teacher routes
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');


    // Track-Strand AJAX
    Route::get('/strands', [TrackStrandController::class, 'getStrands'])->name('strands.get');

    // Enrollment page (dynamic) - placed last to avoid conflicts
    Route::get('/enrollment/{page}', [EnrollmentController::class, 'show'])->name('enrollment.show');
});

require __DIR__ . '/auth.php';
