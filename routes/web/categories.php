<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GetCategoriesToMigrateFromController;
use App\Http\Controllers\ListExpenseCategoriesController;
use App\Http\Controllers\ListIncomeCategoriesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'categorias'], function () {
    Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
    Route::patch('/{category}', [CategoriesController::class, 'update'])->name('categories.update');

    Route::get('/{category}/checar-para-deletar', [CategoriesController::class, 'checkToDelete'])->name('categories.checkToDelete');
    Route::get('/{category}/listar-para-migrar', GetCategoriesToMigrateFromController::class)->name('categories.listToMigrate');
    Route::post('/{category}/migrar-para-deletar', [CategoriesController::class, 'migrateToDestroy'])->name('categories.migrateToDestroy');
    Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

    Route::get('/receitas', ListIncomeCategoriesController::class)->name('income-categories.index');
    Route::get('/despesas', ListExpenseCategoriesController::class)->name('expense-categories.index');
});
