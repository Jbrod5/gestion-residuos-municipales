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
        Schema::table('cuadrillas', function (Blueprint $table) {
            $table->foreignId('id_camion')->nullable()->after('id_cuadrilla')->constrained('camiones', 'id_camion')->nullOnDelete();
            $table->foreignId('id_zona')->nullable()->after('id_camion')->constrained('zonas', 'id_zona')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuadrillas', function (Blueprint $table) {
            $table->dropForeign(['id_camion']);
            $table->dropForeign(['id_zona']);
            $table->dropColumn(['id_camion', 'id_zona']);
        });
    }
};
