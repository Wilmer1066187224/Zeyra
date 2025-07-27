<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Devolucion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class DevolucionController extends Controller
{


    public function index(){

    $devoluciones = Devolucion::with(['venta.cliente', 'productoDevuelto', 'productoNuevo'])->latest()->get();

    return view('devoluciones.index', compact('devoluciones'));
}


public function create() {
    $ventas = Venta::with('cliente')->get();
    $productos = Producto::all();

    return view('devoluciones.create', compact('ventas', 'productos'));
}

public function store(Request $request)
{
  $request->validate([
    'venta_id' => 'required|exists:ventas,id',
    'producto_devuelto_id' => 'required|exists:productos,id',
    'producto_nuevo_id' => [
        'nullable',
        'exists:productos,id',
        // Quitar la regla 'different' si permites cambiar por el mismo modelo
        function ($attribute, $value, $fail) use ($request) {
            if ($value && $value == $request->producto_devuelto_id) {
                // Puedes personalizar esta parte: solo fallar si el ID es literalmente el mismo
                $fail('No se puede cambiar por la misma unidad (ID de producto igual).');
            }
        },
    ],
    'cantidad' => 'required|integer|min:1',
    'motivo' => 'nullable|string|max:255',
]);

    DB::beginTransaction();

    try {
        $devolucion = Devolucion::create([
            'venta_id' => $request->venta_id,
            'producto_devuelto_id' => $request->producto_devuelto_id,
            'producto_nuevo_id' => $request->producto_nuevo_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
        ]);

        Producto::where('id', $request->producto_devuelto_id)->increment('stock', $request->cantidad);

        if ($request->filled('producto_nuevo_id')) {
            $productoNuevo = Producto::findOrFail($request->producto_nuevo_id);

            if ($productoNuevo->stock < $request->cantidad) {
                throw new \Exception('No hay suficiente stock del producto nuevo para realizar el cambio.');
            }

            $productoNuevo->decrement('stock', $request->cantidad);
        }

        DB::commit();
       return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada exitosamente.');


    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Error al registrar la devolución: ' . $e->getMessage()]);
    }
}


}
