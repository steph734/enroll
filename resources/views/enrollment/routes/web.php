<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth'])->group(function () {
    // Payment routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{studentId}', [PaymentController::class, 'view'])->name('payments.view');
    Route::post('/payments/check-student', [PaymentController::class, 'checkStudent'])->name('payments.check-student');
}); 