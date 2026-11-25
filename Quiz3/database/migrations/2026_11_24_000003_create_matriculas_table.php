<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla matriculas: un estudiante matriculado en un curso
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 20);
            $table->string('nombre_estudiante', 100);
            $table->foreignId('curso_id')->constrained('cursos'); // no deja borrar un curso con matrículas
            $table->timestamps(); // created_at = fecha de matrícula
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
