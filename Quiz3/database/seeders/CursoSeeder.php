<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Database\Seeder;

// Seed de cursos: son los que aparecen en el formulario de matrícula
class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $isw = Carrera::where('nombre', 'Ingeniería del Software')->first()->id;
        $adm = Carrera::where('nombre', 'Administración de Empresas')->first()->id;
        $con = Carrera::where('nombre', 'Contabilidad y Finanzas')->first()->id;

        $cursos = [
            ['codigo' => 'ISW-611', 'nombre' => 'Programación II',                       'creditos' => 4, 'carrera_id' => $isw],
            ['codigo' => 'ISW-612', 'nombre' => 'Administración de Sistemas Operativos', 'creditos' => 3, 'carrera_id' => $isw],
            ['codigo' => 'ISW-613', 'nombre' => 'Programación en Ambiente Web I',        'creditos' => 4, 'carrera_id' => $isw],
            ['codigo' => 'ISW-711', 'nombre' => 'Bases de Datos II',                     'creditos' => 4, 'carrera_id' => $isw],
            ['codigo' => 'ADM-101', 'nombre' => 'Fundamentos de Administración',         'creditos' => 3, 'carrera_id' => $adm],
            ['codigo' => 'CON-201', 'nombre' => 'Contabilidad Financiera',               'creditos' => 3, 'carrera_id' => $con],
        ];

        foreach ($cursos as $curso) {
            Curso::firstOrCreate(['codigo' => $curso['codigo']], $curso);
        }
    }
}
