<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// MODELO: tabla matriculas
class Matricula extends Model
{
    protected $fillable = ['cedula', 'nombre_estudiante', 'curso_id'];

    // Una matrícula pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
