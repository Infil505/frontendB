<?php

use Illuminate\Support\Facades\Route;


// Mensaje base
Route::get('/', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});
