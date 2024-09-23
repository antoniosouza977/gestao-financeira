<?php

use App\Http\Controllers\IncomesController;
use Illuminate\Support\Facades\Route;

Route::prefix('receitas')->group(function () {
    Route::get('/', [IncomesController::class, 'index'])->name('incomes.index');
    Route::patch('/{transaction}', [IncomesController::class, 'update'])->name('incomes.update');
    Route::post('/', [IncomesController::class, 'store'])->name('incomes.store');
    Route::delete('/{transaction}', [IncomesController::class, 'destroy'])->name('incomes.destroy');
});
