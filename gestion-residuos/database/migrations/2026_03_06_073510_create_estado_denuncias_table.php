<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de estados para las denuncias
    public function up(): void
    {
        Schema::create('estado_denuncias', function (Blueprint $table) {
            $table->id('id_estado_denuncia');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('estado_denuncias');
    }
};
