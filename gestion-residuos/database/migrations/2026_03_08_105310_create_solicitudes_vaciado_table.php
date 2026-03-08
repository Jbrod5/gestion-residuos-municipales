<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('solicitudes_vaciado', function (Blueprint $table) {
            $table->id('id_solicitud');
            // Relaciones usando los nombres de tus tablas existentes
            $table->foreignId('id_punto_verde')->constrained('puntos_verde', 'id_punto_verde')->onDelete('cascade');
            $table->foreignId('id_contenedor')->constrained('contenedores', 'id_contenedor')->onDelete('cascade');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->onDelete('set null');

            $table->string('estado', 50)->default('Pendiente');
            $table->double('volumen_m3')->nullable();
            $table->datetime('fecha_solicitud')->useCurrent();
            $table->datetime('fecha_atencion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_vaciado');
    }
};