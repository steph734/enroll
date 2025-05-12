<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectManageController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrackStrandController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionLineController;
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
    Route::get('/students', [StudentController::class, 'index'])->name('student.index');
    Route::get('/students/{id}/{formtype}', [StudentController::class, 'edit'])
        ->name('student.edit')
        ->where('formtype', 'view|studentedit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::get('/students/filter', [StudentController::class, 'filter'])->name('student.filter');
    Route::get('/students/search', [StudentController::class, 'search'])->name('student.search');

    // Teacher routes
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::get('/teachers/{formtype}', [EnrollmentController::class, 'show'])->name('enrollment.show');
    Route::get('/teachers/{id}/{formtype?}', [TeacherController::class, 'edit'])
        ->name('teachers.edit')
        ->where('formtype', 'view|teacheredit');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Subject routes
    Route::get('/enrollment/subjects', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/enrollment/subjects/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::get('/enrollment/subjects/{id}/{formtype}', [SubjectController::class, 'edit'])
        ->name('subject.edit')
        ->where('formtype', 'view|subjectedit');
    Route::post('/enrollment/subjects', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/enrollment/subjects/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/enrollment/subjects/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    // Section routes
    Route::get('/sections', [SectionController::class, 'index'])->name('section.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('section.create');
    Route::get('/sections/{id}/edit', [SectionController::class, 'edit'])->name('section.edit');
    Route::post('/sections', [SectionController::class, 'store'])->name('section.store');
    Route::put('/sections/{id}', [SectionController::class, 'update'])->name('section.update');
    Route::delete('/sections/{id}', [SectionController::class, 'destroy'])->name('section.destroy');

    // Payment routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');

    // Section Line routes
    Route::get('/section/{section}/students', [SectionLineController::class, 'index'])->name('sectionline.index');
    Route::post('/section/{section}/students', [SectionLineController::class, 'store'])->name('sectionline.store');
    Route::delete('/sectionline/{sectionLine}', [SectionLineController::class, 'destroy'])->name('sectionline.destroy');

    //Subject Management
    // Subject Management
    Route::get('/enrollment/subjectmanagement', [SubjectManageController::class, 'index'])->name('subjectmanage.index');
    Route::post('/enrollment/subjectmanagement/assign', [SubjectManageController::class, 'assign'])->name('subject.assign');
    Route::post('/enrollment/subjectmanagement/assign-teacher', [SubjectManageController::class, 'assignTeacher'])->name('subject.assignTeacher');
    // Track-Strand AJAX
    Route::get('/strands', [TrackStrandController::class, 'getStrands'])->name('strands.get');

    // Enrollment page (dynamic) - placed last to avoid conflicts
    Route::get('/enrollment/{page}', [EnrollmentController::class, 'show'])->name('enrollment.show')
        ->where('page', '(dashboard|students|teachers|payment|class_schedule|reports|accounts|enrollment_form|teacher_form|edit|studentedit|sections)');

    // Add any other routes that require authentication here
});

require __DIR__ . '/auth.php';
