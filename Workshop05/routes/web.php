<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

// La página principal redirige a la lista
Route::get('/', fn () => redirect()->route('productos.index'));

// Una sola línea crea las 7 rutas del CRUD (index, create, store, show, edit, update, destroy)
Route::resource('productos', ProductoController::class);
