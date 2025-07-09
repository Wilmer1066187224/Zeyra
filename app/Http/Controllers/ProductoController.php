<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $productos = Producto::with('categoria')->get(); // 👈 Aquí está la clave
    return view('productos.index', compact('productos'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

          $categorias = \App\Models\Categoria::all();
         return view('productos.create',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
    'nombre' => 'required|string',
   'codigo' => 'required|string|unique:productos,codigo',
    'precio' => 'required|numeric|min:0',
    'stock' => 'required|integer|min:0',
    'stock_minimo' => 'required|integer|min:0',
    'categoria_id' => 'nullable|exists:categorias,id',
]);


        Producto::create($request->all());

       return redirect()->route('productos.index')->with('swal', 'Producto creado correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
           $categorias = \App\Models\Categoria::all();
         return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
        {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id,
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);


    $producto->update($request->all());

 return redirect()->route('productos.index')->with('swal', 'Producto actualizado correctamente');

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
       $producto->delete();
return redirect()->route('productos.index')->with('swal_delete', 'Producto eliminado correctamente.');


    
    }
}
