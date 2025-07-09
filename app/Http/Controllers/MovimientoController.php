<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $movimientos = Movimiento::with('producto')->latest()->get();
        return view('movimientos.index', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('movimientos.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'tipo' => 'required|in:entrada,salida',
        'cantidad' => 'required|integer|min:1',
        'descripcion' => 'nullable|string|max:255',
    ]);

    $producto = Producto::findOrFail($request->producto_id);

    if ($request->tipo === 'salida' && $producto->stock < $request->cantidad) {
        return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.'])->withInput();
    }

    $movimiento = Movimiento::create($request->all());

    if ($movimiento->tipo === 'entrada') {
        $producto->increment('stock', $movimiento->cantidad);
    } else {
        $producto->decrement('stock', $movimiento->cantidad);
    }

    return redirect()->route('movimientos.index')->with('swal', 'Movimiento registrado correctamente.');
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
        //
    }
}
