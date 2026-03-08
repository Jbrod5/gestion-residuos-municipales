<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de solicitudes de vaciado municipal
     */
    public function up(): void
    {
        Schema::create('solicitudes_vaciado', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->foreignId('id_punto_verde')->constrained('puntos_verde', 'id_punto_verde')->cascadeOnDelete();
            $table->foreignId('id_contenedor')->constrained('contenedores', 'id_contenedor')->cascadeOnDelete();
            $table->enum('estado', ['Pendiente', 'Atendida', 'Cancelada'])->default('Pendiente');
            $table->dateTime('fecha_solicitud')->useCurrent();
            $table->dateTime('fecha_atencion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración municipal
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_vaciado');
    }
};
