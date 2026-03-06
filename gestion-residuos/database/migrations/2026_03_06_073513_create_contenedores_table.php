<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla que mide la capacidad de acopio por punto verde
    public function up(): void
    {
        Schema::create('contenedores', function (Blueprint $table) {
            $table->id('id_contenedor');
            $table->foreignId('id_punto_verde')->constrained('puntos_verde', 'id_punto_verde')->cascadeOnDelete();
            $table->foreignId('id_material')->constrained('materiales', 'id_material')->cascadeOnDelete();
            $table->float('capacidad_maxima_m3');
            $table->float('nivel_actual_m3')->default(0);
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('contenedores');
    }
};
