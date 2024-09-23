<?php

use App\Http\Controllers\IncomePromisesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'receitas-recorrentes'], function () {
    Route::get('/', [IncomePromisesController::class, 'index'])->name('income-promises.index');
    Route::get('/criar', [IncomePromisesController::class, 'create'])->name('income-promises.create');
    Route::post('/criar', [IncomePromisesController::class, 'store'])->name('income-promises.store');
    Route::get('/{promise}/editar', [IncomePromisesController::class, 'edit'])->name('income-promises.edit');
    Route::patch('/{promise}/editar', [IncomePromisesController::class, 'update'])->name('income-promises.update');
    Route::delete('/{promise}/excluir', [IncomePromisesController::class, 'destroy'])->name('income-promises.destroy');
});
