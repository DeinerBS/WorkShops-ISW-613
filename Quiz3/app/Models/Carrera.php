<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// MODELO: tabla carreras
class Carrera extends Model
{
    protected $fillable = ['nombre'];

    // Una carrera tiene muchos cursos
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
