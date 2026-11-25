<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Se ejecuta con: php artisan migrate --seed
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Primero carreras, porque los cursos dependen de ellas
        $this->call([
            CarreraSeeder::class,
            CursoSeeder::class,
        ]);
    }
}
