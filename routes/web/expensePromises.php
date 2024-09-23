<?php

use App\Http\Controllers\ExpensePromisesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'despesas-recorrentes'], function () {
    Route::get('/', [ExpensePromisesController::class, 'index'])->name('expense-promises.index');
    Route::get('/criar', [ExpensePromisesController::class, 'create'])->name('expense-promises.create');
    Route::post('/criar', [ExpensePromisesController::class, 'store'])->name('expense-promises.store');
    Route::get('/{promise}/editar', [ExpensePromisesController::class, 'edit'])->name('expense-promises.edit');
    Route::patch('/{promise}/editar', [ExpensePromisesController::class, 'update'])->name('expense-promises.update');
    Route::delete('/{promise}/excluir', [ExpensePromisesController::class, 'destroy'])->name('expense-promises.destroy');
});
