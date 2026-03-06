<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla donde se programan y asignan las rutas
    public function up(): void
    {
        Schema::create('asignacion_rutas', function (Blueprint $table) {
            $table->id('id_asignacion_ruta');
            $table->foreignId('id_ruta')->constrained('rutas', 'id_ruta')->cascadeOnDelete();
            $table->foreignId('id_camion')->constrained('camiones', 'id_camion')->cascadeOnDelete();
            $table->foreignId('id_cuadrilla')->nullable()->constrained('cuadrillas', 'id_cuadrilla')->nullOnDelete();
            $table->foreignId('id_conductor')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->foreignId('id_estado_asignacion_ruta')->constrained('estado_asignacion_rutas', 'id_estado_asignacion_ruta');
            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->float('basura_estimada_ton')->nullable();
            $table->float('basura_recolectada_ton')->nullable();
            $table->text('notas_incidencias')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('asignacion_rutas');
    }
};
