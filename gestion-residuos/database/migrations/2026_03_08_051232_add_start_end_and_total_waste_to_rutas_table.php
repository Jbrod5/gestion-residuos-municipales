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
            $table->decimal('latitud_inicio', 10, 8)->after('distancia_km')->nullable();
            $table->decimal('longitud_inicio', 11, 8)->after('latitud_inicio')->nullable();
            $table->decimal('latitud_fin', 10, 8)->after('longitud_inicio')->nullable();
            $table->decimal('longitud_fin', 11, 8)->after('latitud_fin')->nullable();
            $table->decimal('basura_total_estimada', 10, 2)->after('longitud_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropColumn(['latitud_inicio', 'longitud_inicio', 'latitud_fin', 'longitud_fin', 'basura_total_estimada']);
        });
    }
};
