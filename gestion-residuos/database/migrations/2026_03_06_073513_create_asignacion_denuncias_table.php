<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla para asignar la atención de una denuncia a una cuadrilla
    public function up(): void
    {
        Schema::create('asignacion_denuncias', function (Blueprint $table) {
            $table->id('id_asignacion_denuncia');
            $table->foreignId('id_denuncia')->constrained('denuncias', 'id_denuncia')->cascadeOnDelete();
            $table->foreignId('id_cuadrilla')->constrained('cuadrillas', 'id_cuadrilla')->cascadeOnDelete();
            $table->date('fecha_asignacion');
            $table->date('fecha_atencion')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('asignacion_denuncias');
    }
};
