<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade vinculación de punto verde a usuarios y densidad a materiales municipal
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreignId('id_punto_verde')->nullable()->constrained('puntos_verde', 'id_punto_verde')->nullOnDelete()->after('id_rol');
        });

        Schema::table('materiales', function (Blueprint $table) {
            $table->float('densidad_kg_m3')->default(100)->after('descripcion');
        });
    }

    /**
     * Revierte los cambios municipal
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['id_punto_verde']);
            $table->dropColumn('id_punto_verde');
        });

        Schema::table('materiales', function (Blueprint $table) {
            $table->dropColumn('densidad_kg_m3');
        });
    }
};
