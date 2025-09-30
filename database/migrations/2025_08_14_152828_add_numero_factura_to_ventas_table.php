<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Lo dejamos nullable para no romper datos existentes.
            $table->string('numero_factura', 20)->nullable()->unique()->after('id');
        });

        // (OPCIONAL) Si ya tienes ventas y quieres numerarlas enseguida:
        DB::transaction(function () {
            $ventas = DB::table('ventas')->orderBy('id')->lockForUpdate()->get();
            $consecutivo = 1;
            foreach ($ventas as $v) {
                // Sólo numeramos si no tiene número aún
                if (empty($v->numero_factura)) {
                    $nf = 'FAC-' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
                    DB::table('ventas')->where('id', $v->id)->update(['numero_factura' => $nf]);
                    $consecutivo++;
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropUnique('ventas_numero_factura_unique');
            $table->dropColumn('numero_factura');
        });
    }
};
