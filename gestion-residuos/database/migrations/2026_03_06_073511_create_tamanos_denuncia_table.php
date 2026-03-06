<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla para medir la magnitud de las denuncias
    public function up(): void
    {
        Schema::create('tamanos_denuncia', function (Blueprint $table) {
            $table->id('id_tamano_denuncia');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('tamanos_denuncia');
    }
};
