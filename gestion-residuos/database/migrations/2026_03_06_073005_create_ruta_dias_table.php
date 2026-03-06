<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla intermedia que define qué días se recorre cada ruta
    public function up(): void
    {
        Schema::create('ruta_dia', function (Blueprint $table) {
            $table->id('id_ruta_dia');
            $table->foreignId('id_ruta')->constrained('rutas', 'id_ruta')->cascadeOnDelete();
            $table->foreignId('id_dia_semana')->constrained('dias_semana', 'id_dia_semana')->cascadeOnDelete();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('ruta_dia');
    }
};
