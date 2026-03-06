<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de la flota de camiones recolectores
    public function up(): void
    {
        Schema::create('camiones', function (Blueprint $table) {
            $table->id('id_camion');
            $table->foreignId('id_estado_camion')->constrained('estado_camiones', 'id_estado_camion');
            $table->string('placa')->unique();
            $table->float('capacidad_toneladas');
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('camiones');
    }
};
