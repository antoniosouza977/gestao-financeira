<?php

declare(strict_types=1);

use App\Http\Controllers\AddExpenseFromDashboardController;
use App\Http\Controllers\ExpensesController;
use Illuminate\Support\Facades\Route;

Route::prefix('despesas')->group(function (): void {
    Route::get('/', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::patch('/{transaction}', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::post('/', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::delete('/{transaction}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');

    Route::post('dash/add', [AddExpenseFromDashboardController::class, 'store'])->name('add-expense');
    Route::patch('dash/update/{transaction}', [AddExpenseFromDashboardController::class, 'update'])->name('update-expense');
});
