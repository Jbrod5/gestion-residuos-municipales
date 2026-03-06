<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de cuadrillas para agrupar trabajadores
    public function up(): void
    {
        Schema::create('cuadrillas', function (Blueprint $table) {
            $table->id('id_cuadrilla');
            $table->string('nombre');
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('cuadrillas');
    }
};
