<?php

namespace App\Http\Controllers;


use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Notifications\StockBajoNotification;
use Illuminate\Support\Facades\Notification;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $ventas = Venta::latest('fecha_venta')->with('producto')->get();
    return view('ventas.index', compact('ventas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id', // <- nuevo
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
        'precio_unitario' => 'required|numeric|min:0',
        'fecha_venta' => 'required|date',
    ]);

    $producto = Producto::findOrFail($request->producto_id);

    if ($producto->stock < $request->cantidad) {
        return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible.']);
    }

    $total = $request->cantidad * $request->precio_unitario;

    $venta = Venta::create([
        'cliente_id' => $request->cliente_id, // <- nuevo
        'producto_id' => $request->producto_id,
        'cantidad' => $request->cantidad,
        'precio_unitario' => $request->precio_unitario,
        'total' => $total,
        'fecha_venta' => $request->fecha_venta,
    ]);

    $producto->decrement('stock', $request->cantidad);
           
    // 🚨 Verificar y notificar si el stock está por debajo del mínimo
    if ($producto->stock <= $producto->stock_minimo) {
        auth()->user()->notify(new StockBajoNotification($producto));
    }

    return redirect()->route('ventas.index')->with('swal', 'Venta registrada correctamente.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
{
    // Validar que la venta tenga producto asociado
    if ($venta->producto) {
        // Devolver el stock vendido al producto
        $venta->producto->increment('stock', $venta->cantidad);
    }

    // Eliminar la venta
    $venta->delete();

    return redirect()->route('ventas.index')->with('swal_delete', 'Venta eliminada correctamente.');
}

}
