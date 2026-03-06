<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla predefinida con los días de la semana
    public function up(): void
    {
        Schema::create('dias_semana', function (Blueprint $table) {
            $table->id('id_dia_semana');
            $table->string('nombre');
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('dias_semana');
    }
};
