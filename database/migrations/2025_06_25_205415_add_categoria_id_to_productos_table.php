<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega el campo categoria_id a productos.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // IMPORTANTE: Agregar nullable() si ya tienes productos existentes
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categorias')
                  ->onDelete('cascade');
        });
    }

    /**
     * Quita el campo categoria_id de productos.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
};
