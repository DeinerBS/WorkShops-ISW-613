<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use Illuminate\Support\Facades\Route;

// Página principal: formulario de matrícula
Route::get('/', [MatriculaController::class, 'create'])->name('matriculas.create');

// Matrícula: guardar, ver el registro y listar
Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
Route::get('/matriculas/{matricula}', [MatriculaController::class, 'show'])->name('matriculas.show');

// CRUD de cursos: crea las 7 rutas (index, create, store, show, edit, update, destroy)
Route::resource('cursos', CursoController::class);
