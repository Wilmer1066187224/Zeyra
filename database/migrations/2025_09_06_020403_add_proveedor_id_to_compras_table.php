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
        Schema::table('compras', function (Blueprint $table) {
           $table->unsignedBigInteger('proveedor_id')->nullable()->after('producto_id');

        // 👇 Relación foránea con proveedores
        $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
           $table->dropForeign(['proveedor_id']);
        $table->dropColumn('proveedor_id');
    });
    }
};
