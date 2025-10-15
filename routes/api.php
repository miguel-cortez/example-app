<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Middleware\ReferrerPolicyMiddleware;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/dashboard/productos', [ProductoController::class, 'index']);
Route::post('/dashboard/productos/upload', [ProductoController::class, 'upload'])->middleware([ReferrerPolicyMiddleware::class])->name('prueba');
Route::put('/dashboard/productos/remove', [ProductoController::class, 'remove']);
Route::get('/dashboard/productos/fichas_tecnicas', [ProductoController::class, 'obtenerFichasTecnicas']);
Route::get('/dashboard/grafico_productos_categorias', [CategoriaController::class, 'getData']);