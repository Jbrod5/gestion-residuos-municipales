<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Vincula rutas a puntos verdes para identificar servicios de vaciado municipal
     */
    public function up(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->foreignId('id_punto_verde')->nullable()->constrained('puntos_verde', 'id_punto_verde')->nullOnDelete()->after('poblacion_estimada');
        });
    }

    /**
     * Revierte la migración municipal
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropForeign(['id_punto_verde']);
            $table->dropColumn('id_punto_verde');
        });
    }
};
