<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('producto')->get(); // 👈 Muy importante el with('producto')
    return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('compras.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'fecha_compra' => 'required|date',
        ]);

        $total = $request->cantidad * $request->precio_unitario;

        $compra = Compra::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'total' => $total,
            'fecha_compra' => $request->fecha_compra,
        ]);

        // Aumentar stock del producto
        $compra->producto->increment('stock', $request->cantidad);

        return redirect()->route('compras.index')->with('swal', 'Compra registrada correctamente.');
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
 public function destroy(string $id)
{
    $compra = \App\Models\Compra::with('producto')->findOrFail($id);

    // Verificar si el producto existe antes de ajustar el stock
    if ($compra->producto) {
        $compra->producto->decrement('stock', $compra->cantidad);
    }

    $compra->delete();

    return redirect()->route('compras.index')->with('swal_delete', 'Compra eliminada correctamente.');
}



}
