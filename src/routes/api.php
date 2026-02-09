<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\utilsController;

Route::get('/autos', [AutoController::class, 'index']);
Route::post('/autos', [AutoController::class, 'store']);
Route::get('/autos/{id}', [AutoController::class, 'show']);
Route::put('/autos/{id}', [AutoController::class, 'update']);
Route::delete('/autos/{id}', [AutoController::class, 'destroy']);

// Funcionalidades adicionales para Adicionales
Route::post('/autos/cotizacion', [utilsController::class, 'cotizacion']);

// ToDo: Crear los endpoints necesarios para el CRUD de Vendedores

// ToDo: Crear los endpoints necesarios para el CRUD de Ventas

// ToDo: Crear los endpoints necesarios para el CRUD de Clientes


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
