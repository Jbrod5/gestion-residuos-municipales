<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla intermedia para asignar trabajadores a cuadrillas
    public function up(): void
    {
        Schema::create('cuadrilla_trabajador', function (Blueprint $table) {
            $table->id('id_cuadrilla_trabajador');
            $table->foreignId('id_cuadrilla')->constrained('cuadrillas', 'id_cuadrilla')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('cuadrilla_trabajador');
    }
};
