<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de posibles estados para una recolección
    public function up(): void
    {
        Schema::create('estado_asignacion_rutas', function (Blueprint $table) {
            $table->id('id_estado_asignacion_ruta');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('estado_asignacion_rutas');
    }
};
