<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla para el registro de denuncias ciudadanas
    public function up(): void
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id('id_denuncia');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_estado_denuncia')->constrained('estado_denuncias', 'id_estado_denuncia');
            $table->foreignId('id_tamano_denuncia')->constrained('tamanos_denuncia', 'id_tamano_denuncia');
            $table->text('descripcion');
            $table->date('fecha');
            $table->string('foto_antes')->nullable();
            $table->string('foto_despues')->nullable();
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
