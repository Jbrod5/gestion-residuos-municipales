<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de los puntos exactos (coordenadas) de la ruta
    public function up(): void
    {
        Schema::create('puntos_recoleccion', function (Blueprint $table) {
            $table->id('id_punto_recoleccion');
            $table->foreignId('id_ruta')->constrained('rutas', 'id_ruta')->cascadeOnDelete();
            $table->integer('posicion_orden');
            $table->double('latitud');
            $table->double('longitud');
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('puntos_recoleccion');
    }
};
