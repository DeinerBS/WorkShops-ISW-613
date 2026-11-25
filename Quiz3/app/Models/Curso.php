<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// MODELO: tabla cursos
class Curso extends Model
{
    protected $fillable = ['nombre', 'codigo', 'creditos', 'carrera_id'];

    // Un curso pertenece a una carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    // Un curso tiene muchas matrículas
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
