<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;


// Rutas agrupadas para categorías
Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);

    // Ítems de una categoría específica
    Route::get('/{category}/items', [ItemController::class, 'index']);
});

// Rutas agrupadas para ítems
Route::prefix('items')->group(function () {
    Route::get('/search', [ItemController::class, 'search']);
    Route::get('/', [ItemController::class, 'all']);
    Route::get('/{item}', [ItemController::class, 'show']);
    Route::put('/{item}', [ItemController::class, 'update']);
    Route::delete('/{item}', [ItemController::class, 'destroy']);
    Route::post('/', [ItemController::class, 'store']);
});
