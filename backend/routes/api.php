<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\usuarios;
use App\Http\Controllers\Api\clientes;
use App\Http\Controllers\Api\productos;
use App\Http\Controllers\Api\categorias;
use App\Http\Controllers\Api\ventas;
use App\Http\Controllers\Api\detalle_ventas;
use App\Http\Controllers\Api\compras;
use App\Http\Controllers\Api\detalle_compras;
use App\Http\Controllers\Api\proveedores;

// Rutas públicas
Route::post('/auth/logear', [AuthController::class, 'logear']);
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);

// Rutas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/usuarios', [usuarios::class, 'index']);
    Route::post('/usuarios', [usuarios::class, 'store']);
    Route::get('/usuarios/{id}', [usuarios::class, 'edit']);
    Route::put('/usuarios/{id}', [usuarios::class, 'update']);
    Route::delete('/usuarios/{id}', [usuarios::class, 'destroy']);
    Route::get('/usuarios/tbody', [usuarios::class, 'tbody']);
    Route::put('/usuarios/{id}/estado/{estado}', [usuarios::class, 'estado']);
    Route::patch('usuarios/{id}/estado/{estado}', [usuarios::class, 'updateEstado']);

    Route::get('/clientes', [clientes::class, 'index']);
    Route::post('/clientes', [clientes::class, 'store']);
    Route::get('/clientes/{id}', [clientes::class, 'edit']);
    Route::put('/clientes/{id}', [clientes::class, 'update']);
    Route::delete('/clientes/{id}', [clientes::class, 'destroy']);

    Route::get('/productos', [productos::class, 'index']);
    Route::post('/productos', [productos::class, 'store']);
    Route::get('/productos/{id}', [productos::class, 'edit']);
    Route::put('/productos/{id}', [productos::class, 'update']);
    Route::delete('/productos/{id}', [productos::class, 'destroy']);
    Route::put('/productos/{id}/estado/{estado}', [productos::class, 'estado']);

    Route::get('/categorias', [categorias::class, 'index']);
    Route::post('/categorias', [categorias::class, 'store']);
    Route::get('/categorias/{id}', [categorias::class, 'show']);
    Route::put('/categorias/{id}', [categorias::class, 'update']);
    Route::delete('/categorias/{id}', [categorias::class, 'destroy']);

    Route::get('/ventas', [ventas::class, 'index']);
    Route::post('/ventas', [ventas::class, 'store']);
    Route::get('/ventas/{id}', [ventas::class, 'show']);
    Route::put('/ventas/{id}', [ventas::class, 'update']);
    Route::delete('/ventas/{id}', [ventas::class, 'destroy']);

    Route::get('/detalle_ventas', [detalle_ventas::class, 'index']);
    Route::post('/detalle_ventas', [detalle_ventas::class, 'store']);
    Route::get('/detalle_ventas/{id}', [detalle_ventas::class, 'show']);
    Route::put('/detalle_ventas/{id}', [detalle_ventas::class, 'update']);
    Route::delete('/detalle_ventas/{id}', [detalle_ventas::class, 'destroy']);

    Route::get('/compras', [compras::class, 'index']);
    Route::post('/compras', [compras::class, 'store']);
    Route::get('/compras/{id}', [compras::class, 'show']);
    Route::put('/compras/{id}', [compras::class, 'update']);
    Route::delete('/compras/{id}', [compras::class, 'destroy']);

    Route::get('/detalle_compras', [detalle_compras::class, 'index']);
    Route::post('/detalle_compras', [detalle_compras::class, 'store']);
    Route::get('/detalle_compras/{id}', [detalle_compras::class, 'show']);
    Route::put('/detalle_compras/{id}', [detalle_compras::class, 'update']);
    Route::delete('/detalle_compras/{id}', [detalle_compras::class, 'destroy']);

    Route::get('/proveedores', [proveedores::class, 'index']);
    Route::post('/proveedores', [proveedores::class, 'store']);
    Route::get('/proveedores/{id}', [proveedores::class, 'show']);
    Route::put('/proveedores/{id}', [proveedores::class, 'update']);
    Route::delete('/proveedores/{id}', [proveedores::class, 'destroy']);
});
