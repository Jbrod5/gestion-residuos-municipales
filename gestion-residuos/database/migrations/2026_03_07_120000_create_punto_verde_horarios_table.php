<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * crea la tabla para horarios operativos de puntos verdes municipal
     */
    public function up(): void
    {
        Schema::create('punto_verde_horario', function (Blueprint $table) {
            $table->id('id_punto_verde_horario');
            $table->foreignId('id_punto_verde')->constrained('puntos_verde', 'id_punto_verde')->cascadeOnDelete();
            $table->foreignId('id_dia_semana')->constrained('dias_semana', 'id_dia_semana')->cascadeOnDelete();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });
    }

    /**
     * revierte la migración successo total
     */
    public function down(): void
    {
        Schema::dropIfExists('punto_verde_horario');
    }
};
