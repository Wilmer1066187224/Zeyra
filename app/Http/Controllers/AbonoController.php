<?php

namespace App\Http\Controllers;
use App\Models\Abono;
use App\Models\Venta;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'venta_id' => 'required|exists:ventas,id',
        'monto' => 'required|numeric|min:1',
        'metodo_pago' => 'nullable|string|max:50',
        'fecha_abono' => 'nullable|date',
    ]);

    Abono::create([
        'venta_id' => $request->venta_id,
        'monto' => $request->monto,
        'metodo_pago' => $request->metodo_pago,
        'fecha_abono' => $request->fecha_abono ?? now(),
    ]);

    return redirect()->route('ventas.show', $request->venta_id)
        ->with('success', 'Abono registrado correctamente.');
}

}
