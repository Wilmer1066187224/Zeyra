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
        Schema::create('productos', function (Blueprint $table) {
         $table->id();

            $table->string('nombre'); // Nombre del producto
            $table->string('codigo')->unique(); // Código o SKU único
            $table->text('descripcion')->nullable(); // Descripción del producto
            $table->decimal('precio', 10, 2); // Precio unitario
            $table->integer('stock')->default(0); // Cantidad disponible en inventario
            $table->integer('stock_minimo')->default(0); // Stock mínimo recomendado
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
