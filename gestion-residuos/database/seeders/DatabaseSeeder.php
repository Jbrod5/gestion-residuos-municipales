<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,

            DiaSemanaSeeder::class,
            EstadoAsignacionRutaSeeder::class,
            EstadoCamionSeeder::class,
            EstadoDenunciaSeeder::class,
            MaterialSeeder::class,
            RolSeeder::class,
            TamanoDenunciaSeeder::class,
            TipoResiduoSeeder::class,
            TipoZonaSeeder::class,
            UsuarioSeeder::class,
            ZonaSeeder::class,


            //RutaSeeder::class,            
            //EstadoDenunciaSeeder::class,

            
        ]);
    }
}
