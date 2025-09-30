<?php

namespace App\Http\Controllers;


use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }


    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('swal', 'Proveedor creado correctamente.');
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
public function edit(Proveedor $proveedor)
{
    return view('proveedores.edit', compact('proveedor'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Proveedor $proveedor)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'nullable|email',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
    ]);

    $proveedor->update($request->all());

    return redirect()->route('proveedores.index')
        ->with('success', 'Proveedor actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
{
    $proveedor->delete();

    return redirect()->route('proveedores.index')->with('delete', 'Proveedor eliminado correctamente.');
}

}
