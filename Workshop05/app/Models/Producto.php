<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// MODELO: representa la tabla productos (Eloquent ORM)
class Producto extends Model
{
    protected $table = 'productos';

    // Campos que se pueden llenar desde el formulario
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock'];
}
