<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/enrollment/{page}', [EnrollmentController::class, 'show'])->name('enrollment.show');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('login.login');
});

Route::get('/dashboard', function () {
    return view('enrollment.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/signup', function () {
    return view('login.signup');
});

Route::get('/enrollment/enrollment_form', [StudentController::class, 'index'])->name('student.index');
Route::get('/enrollment/enrollment_form', [TeacherController::class, 'create'])->name('student.create');
Route::post('/enrollment/enrollment_form', [StudentController::class, 'store'])->name('student.store');

Route::resource('/enrollment', EnrollmentController::class); 
Route::resource('teachers', TeacherController::class);

Route::get('/enrollment/teacher_form', [TeacherController::class, 'create'])->name('enrollment.show');
Route::post('/enrollment/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('enrollment.teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/enrollment/teacher_form', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/enrollment/teacher_form', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
Route::delete('/enrollment/teachers/{id}', [TeacherController::class, 'destroy'])->name('enrollment.teachers.destroy');



require __DIR__ . '/auth.php';