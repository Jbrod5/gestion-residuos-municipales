<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla para registrar las zonas de recolección
    public function up(): void
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->id('id_zona');
            $table->foreignId('id_tipo_zona')->constrained('tipo_zonas', 'id_tipo_zona');
            $table->string('nombre');
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('zonas');
    }
};
