<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla de tipos de zonas o sectores
    public function up(): void
    {
        Schema::create('tipo_zonas', function (Blueprint $table) {
            $table->id('id_tipo_zona');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('tipo_zonas');
    }
};
