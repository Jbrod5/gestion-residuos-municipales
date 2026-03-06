<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Crea la tabla donde se registra la entrada de material reciclado
    public function up(): void
    {
        Schema::create('entregas_reciclaje', function (Blueprint $table) {
            $table->id('id_entrega');
            $table->foreignId('id_punto_verde')->constrained('puntos_verde', 'id_punto_verde')->cascadeOnDelete();
            $table->foreignId('id_material')->constrained('materiales', 'id_material')->cascadeOnDelete();
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->nullOnDelete();
            $table->float('cantidad_kg');
            $table->dateTime('fecha');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    // Revierte la migración borrando las tablas creadas
    public function down(): void
    {
        Schema::dropIfExists('entregas_reciclaje');
    }
};
