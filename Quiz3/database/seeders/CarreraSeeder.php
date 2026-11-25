<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Seeder;

// Seed de carreras (datos fijos en la BD)
class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            'Ingeniería del Software',
            'Administración de Empresas',
            'Contabilidad y Finanzas',
            'Ingeniería en Producción Industrial',
            'Gestión Ecoturística',
        ];

        foreach ($carreras as $nombre) {
            Carrera::firstOrCreate(['nombre' => $nombre]); // no duplica si se corre dos veces
        }
    }
}
