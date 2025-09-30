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
        Schema::table('ventas', function (Blueprint $table) {
            if (Schema::hasColumn('ventas', 'producto_id')) {
                $table->dropForeign(['producto_id']);
                $table->dropColumn('producto_id');
            }
            if (Schema::hasColumn('ventas', 'cantidad')) {
                $table->dropColumn('cantidad');
            }
            if (Schema::hasColumn('ventas', 'precio_unitario')) {
                $table->dropColumn('precio_unitario');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 12, 2)->nullable();
        });
    }
};
