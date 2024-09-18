<?php

use App\Http\Controllers\ConfirmIncomePaymentController;
use App\Http\Controllers\IncomeCategoriesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {

    Route::resource('incomes', IncomesController::class);
    Route::resource('income-categories', IncomeCategoriesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::post('confirm-payment', ConfirmIncomePaymentController::class)->name('confirm-payment');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


