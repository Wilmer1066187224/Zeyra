<?php

namespace App\Http\Controllers;


use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Notifications\StockBajoNotification;
use Illuminate\Support\Facades\Notification;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;
use LaravelDaily\Invoices\Classes\Party;
use App\Models\Factura;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request){
    $query = Venta::with(['producto', 'cliente'])->latest('fecha_venta');

    if ($request->filled('cliente')) {
        $query->whereHas('cliente', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->cliente . '%');
        });
    }

    $ventas = $query->get();

    return view('ventas.index', compact('ventas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(){

        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request){
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
   public function show(Venta $venta)
{
    return view('ventas.show', compact('venta'));
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
    public function destroy(Venta $venta){
    // Validar que la venta tenga producto asociado
    if ($venta->producto) {
        // Devolver el stock vendido al producto
        $venta->producto->increment('stock', $venta->cantidad);
    }

    // Eliminar la venta
    $venta->delete();

    return redirect()->route('ventas.index')->with('swal_delete', 'Venta eliminada correctamente.');
}

public function generarFactura(Venta $venta){
    // Verifica si ya se generó factura
    $factura = Factura::where('venta_id', $venta->id)->first();
    $venta = Venta::with('abonos')->findOrFail($venta->id);

   $totalAbonado = $venta->abonos->sum('monto');
   $saldoPendiente = $venta->total - $totalAbonado;

    if (!$factura) {
        $numeroFactura = $this->generarNumeroFactura();

        $factura = Factura::create([
            'venta_id' => $venta->id,
            'numero' => $numeroFactura,
        ]);
    }

    $cliente = $venta->cliente;
    $producto = $venta->producto;

    $customer = new Buyer([
        'name' => $cliente->nombre,
        'custom_fields' => [
            'Email' => $cliente->email,
            'Teléfono' => $cliente->telefono,
            'Dirección' => $cliente->direccion,
        ],
    ]);

    $seller = new Party([
        'name' => 'Tu Empresa o Negocio',
        'custom_fields' => [
            'NIT' => '123456789-0',
            'Dirección' => 'Chinú, Córdoba',
            'Teléfono' => '300 123 4567',
        ]
    ]);

    $item = InvoiceItem::make($producto->nombre)
        ->pricePerUnit($venta->precio_unitario)
        ->quantity($venta->cantidad)
        ->units('und');

   $invoice = Invoice::make()
    ->series($factura->numero)
    ->serialNumberFormat('{SERIES}')
    ->buyer($customer)
    ->seller($seller)
    ->date(Carbon::parse($venta->fecha_venta))
    ->addItem($item)
    ->logo(public_path('vendor/invoices/sample-logo.png'))
    ->template('default') // Usa la vista resources/views/vendor/invoices/default.blade.php
    ->filename('Factura_' . Carbon::parse($venta->fecha_venta)->format('d-m-Y') . '_#' . $venta->id)
    ->notes('Gracias por su compra.')
    ->currencySymbol('$')
    ->currencyCode('COP')
    ->currencyFormat('{SYMBOL} {VALUE}')
    ->currencyThousandsSeparator('.')
    ->currencyDecimalPoint(',');

// Añadir venta al objeto
$invoice->venta = $venta;

return $invoice->stream();

}


            private function generarNumeroFactura()
            {
                $ultimo = Factura::latest('id')->first();
                $numero = $ultimo ? (int) substr($ultimo->numero, -4) + 1 : 1;
                return 'FAC-' . str_pad($numero, 4, '0', STR_PAD_LEFT); // Ej: FAC-0005
            }




}
