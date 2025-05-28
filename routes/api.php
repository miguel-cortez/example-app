<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/dashboard/productos', [ProductoController::class, 'index']);
Route::get('/dashboard/productos/fichas_tecnicas', [ProductoController::class, 'obtenerFichasTecnicas']);
Route::get('/dashboard/grafico_productos_categorias', [CategoriaController::class, 'getData']);