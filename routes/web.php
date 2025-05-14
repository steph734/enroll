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
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AccountsController;
use App\Models\PaymentLine;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Route::get('/dashboard', function () {
    //     return view('enrollment.dashboard');
    // })->name('dashboard');

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
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::post('/students/update-status', [StudentController::class, 'updateStatus'])->name('students.updateStatus');
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
    Route::post('/teachers/update-status', [TeacherController::class, 'updateStatus'])->name('teachers.updateStatus');

    // Subject routes
    Route::get('/enrollment/subjects', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/enrollment/subjects/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::get('/enrollment/subjects/{id}/{formtype}', [SubjectController::class, 'edit'])
        ->name('subject.edit')
        ->where('formtype', 'view|subjectedit');
    Route::post('/enrollment/subjects', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/enrollment/subjects/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/enrollment/subjects/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    // Schedule routes
    Route::get('/enrollment/schedules', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/enrollment/schedules/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/enrollment/schedules', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/enrollment/schedules/{schedule}/{formtype}', [ScheduleController::class, 'edit'])
        ->name('schedule.edit')
        ->where('formtype', 'view|scheduleedit');
    Route::put('/enrollment/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/enrollment/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

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

    // Subject Management
    Route::get('/enrollment/subjectmanagement', [SubjectManageController::class, 'index'])->name('subjectmanage.index');
    Route::post('/enrollment/subjectmanagement/assign', [SubjectManageController::class, 'assign'])->name('subject.assign');
    Route::post('/enrollment/subjectmanagement/assign-teacher', [SubjectManageController::class, 'assignTeacher'])->name('subject.assignTeacher');
    Route::get('/enrollment/subjects/{id}', [SubjectManageController::class, 'show'])->name('subject.show');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/generate/{type}', [ReportsController::class, 'generate'])->name('reports.generate');
    // Track-Strand AJAX
    Route::get('/strands', [TrackStrandController::class, 'getStrands'])->name('strands.get');



    Route::get('/payments/{studentId}/transactions', function ($studentId) {
        return PaymentLine::where('student_id', $studentId)
            ->with(['payment' => function ($query) {
                $query->select('id', 'payment_date');
            }])
            ->get(['id', 'payment_id', 'amount', 'description', 'payment_method'])
            ->map(function ($line) {
                return [
                    'payment_id' => $line->payment_id,
                    'amount' => $line->amount,
                    'payment_method' => $line->payment_method,
                    'description' => $line->description,
                    'payment_date' => $line->payment->payment_date,
                ];
            });
    });
    //Accs n Payments
    Route::get('/payments/create/{student_id?}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.view');

    Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AccountsController::class, 'store'])->name('accounts.store');
    // Route::patch('/accounts/{user}/deactivate', [AccountsController::class, 'deactivate'])->name('accounts.deactivate');
    Route::patch('/accounts/{id}/status', [AccountsController::class, 'updateStatus'])->name('accounts.status.update');
    // Enrollment page (dynamic) - placed last to avoid conflicts
    Route::get('/enrollment/{page}', [EnrollmentController::class, 'show'])->name('enrollment.show')
        ->where('page', '(dashboard|students|teachers|payment|class_schedule|reports|accounts|enrollment_form|teacher_form|edit|studentedit|sections)');
});

require __DIR__ . '/auth.php';
