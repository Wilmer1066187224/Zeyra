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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
    $table->foreignId('venta_id')->constrained('ventas');
    $table->foreignId('producto_devuelto_id')->constrained('productos');
    $table->foreignId('producto_nuevo_id')->nullable()->constrained('productos');
    $table->integer('cantidad');
    $table->string('motivo')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
