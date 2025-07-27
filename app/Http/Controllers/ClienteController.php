<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $clientes = Cliente::latest()->get();
    return view('clientes.index', compact('clientes'));
}


    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('clientes.create');
}


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'nullable|email',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
    ]);

    Cliente::create($request->all());

    return redirect()->route('clientes.index')->with('swal', 'Cliente registrado correctamente.');
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
        $cliente = Cliente::findOrFail($id);
        return view ('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'nullable|email',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
    ]);
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('swal_update', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    $cliente = Cliente::findOrFail($id);
    $cliente->delete();

    return redirect()->route('clientes.index')->with('swal_delete', 'Cliente eliminado correctamente.');
}

    
}
