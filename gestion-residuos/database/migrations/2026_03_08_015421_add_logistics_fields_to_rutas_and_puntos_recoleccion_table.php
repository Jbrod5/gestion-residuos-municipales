<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->text('camino_coordenadas')->nullable()->after('distancia_km');
        });

        Schema::table('puntos_recoleccion', function (Blueprint $table) {
            $table->float('volumen_estimado_kg')->default(0)->after('longitud');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropColumn('camino_coordenadas');
        });

        Schema::table('puntos_recoleccion', function (Blueprint $table) {
            $table->dropColumn('volumen_estimado_kg');
        });
    }
};
