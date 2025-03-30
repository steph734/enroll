<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;


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


Route::get('/enrollment', [StudentController::class, 'index'])->name('students');
Route::post('/enrollment', [StudentController::class, 'store'])->name('student.store');

Route::get('/enrollment/teacher_form', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/enrollment/teacher_form', [TeacherController::class, 'store'])->name('teachers.store');

require __DIR__ . '/auth.php';
