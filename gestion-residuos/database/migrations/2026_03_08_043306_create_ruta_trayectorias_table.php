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
        Schema::create('ruta_trayectorias', function (Blueprint $table) {
            $table->id('id_trayectoria');
            $table->unsignedBigInteger('id_ruta');
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->integer('orden');
            $table->timestamps();

            $table->foreign('id_ruta')->references('id_ruta')->on('rutas')->onDelete('cascade');
        });

        Schema::table('rutas', function (Blueprint $table) {
            $table->dropColumn('camino_coordenadas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->text('camino_coordenadas')->nullable();
        });
        Schema::dropIfExists('ruta_trayectorias');
    }
};
