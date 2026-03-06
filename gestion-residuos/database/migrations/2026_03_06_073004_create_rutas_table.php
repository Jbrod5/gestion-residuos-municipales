<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla principal para las rutas de los camiones
    public function up(): void
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id('id_ruta');
            $table->foreignId('id_zona')->constrained('zonas', 'id_zona');
            $table->foreignId('id_tipo_residuo')->constrained('tipo_residuos', 'id_tipo_residuo');
            $table->string('nombre');
            $table->integer('poblacion_estimada')->nullable();
            $table->float('distancia_km')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
