<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de centros de acopio o puntos verdes
    public function up(): void
    {
        Schema::create('puntos_verde', function (Blueprint $table) {
            $table->id('id_punto_verde');
            $table->foreignId('id_encargado')->constrained('usuarios', 'id_usuario');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('horario')->nullable();
            $table->float('capacidad_total_m3');
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('puntos_verde');
    }
};
