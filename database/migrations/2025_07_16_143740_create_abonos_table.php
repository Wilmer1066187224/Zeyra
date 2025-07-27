<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('abonos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('venta_id')->constrained()->onDelete('cascade');
        $table->decimal('monto', 10, 2);
        $table->string('metodo_pago')->nullable();
        $table->date('fecha_abono')->default(now());
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonos');
    }
};
