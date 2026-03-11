<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Catálogos
            RolSeeder::class,
            DiaSemanaSeeder::class,
            EstadoAsignacionRutaSeeder::class,
            EstadoCamionSeeder::class,
            EstadoDenunciaSeeder::class,
            MaterialSeeder::class,
            TamanoDenunciaSeeder::class,
            TipoResiduoSeeder::class,
            TipoZonaSeeder::class,
            
            // Datos principales
            ZonaSeeder::class,
            UsuarioSeeder::class,
            CamionesSeeder::class,            
            PuntosVerdeSeeder::class,   
            PuntoVerdeHorarioSeeder::class,       
            ContenedoresSeeder::class,         
            RutasSeeder::class,                 
            RutaDiaSeeder::class,               
            RutaTrayectoriasSeeder::class,      
            PuntosRecoleccionSeeder::class,     
            DenunciasSeeder::class,             
        ]);
    }
}