<?php

use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\ConfirmExpenseOutgoController;
use App\Http\Controllers\ConfirmIncomePaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomeCategoriesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\OutgoingsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::resource('incomes', IncomesController::class);
    Route::resource('income-categories', IncomeCategoriesController::class);
    Route::resource('payments', PaymentsController::class);
    Route::post('confirm-payment', ConfirmIncomePaymentController::class)->name('confirm-payment');
    Route::post('confirm-outgo', ConfirmExpenseOutgoController::class)->name('confirm-outgo');
    Route::resource('expense-categories', ExpenseCategoriesController::class);
    Route::resource('budgets', BudgetsController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('outgoings', OutgoingsController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


