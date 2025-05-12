<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\TrackStrandController;
 use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TransactionController;

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


    Route::prefix('enrollment')->group(function () {
    Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountsController::class, 'create'])->name('accounts.create');
    Route::patch('/accounts/{id}', [AccountsController::class, 'update'])->name('accounts.update');
});


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
     Route::get('/teachers/create', [StudentController::class, 'create'])->name('teachers.create');
    Route::get('/teachers/{formtype}', [EnrollmentController::class, 'show'])->name('enrollment.show');
    Route::get('/teachers/{id}/{formtype?}', [TeacherController::class, 'edit'])
    ->name('teachers.edit')
    ->where('formtype', 'view|edit');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

   
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/{student}', [PaymentController::class, 'show'])->name('payments.show');
Route::get('/payments/{student}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::post('/payments/check-student', [PaymentController::class, 'checkStudent'])->name('payments.check-student');
Route::post('/payments/search-students', [PaymentController::class, 'searchStudents'])->name('payments.search-students');
Route::get('/payments/transactions/{studentid}', [PaymentController::class, 'transactions'])->name('payments.transactions');
Route::get('/payments/{id}', [PaymentController::class, 'view'])->name('payments.view');
Route::get('/payments/history/all', [PaymentController::class, 'allPaymentHistory'])->name('payments.history.all');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transaction.store');
Route::post('/transactions/check-student', [TransactionController::class, 'checkStudent'])->name('transaction.check-student');



Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
Route::get('/schedules/search', [ScheduleController::class, 'search'])->name('schedules.search');
Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Track-Strand AJAX
    Route::get('/strands', [TrackStrandController::class, 'getStrands'])->name('strands.get');

    // Enrollment page (dynamic) - placed last to avoid conflicts
    Route::get('/enrollment/{page}', [EnrollmentController::class, 'show'])->name('enrollment.show');
});

require __DIR__ . '/auth.php';
