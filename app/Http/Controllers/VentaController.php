<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use Carbon\Carbon;
use App\Models\VentaDetalle;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\StockBajoNotification;
use Illuminate\Support\Facades\Auth;


class VentaController extends Controller
{
    /**
     * Listar ventas con filtros.
     */
  public function index(Request $request)
{
    $query = Venta::with(['detalles.producto', 'cliente'])
                  ->orderBy('created_at', 'desc'); // 👈 ventas más recientes primero

    // Filtro por cliente
    if ($request->filled('cliente')) {
        $query->whereHas('cliente', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->cliente . '%');
        });
    }

    // Filtro por fechas
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $query->whereBetween('fecha_venta', [
            $request->fecha_inicio . ' 00:00:00',
            $request->fecha_fin . ' 23:59:59'
        ]);
    } elseif ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_venta', '>=', $request->fecha_inicio);
    } elseif ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_venta', '<=', $request->fecha_fin);
    }

    // Filtro por número de factura
    if ($request->filled('numero_factura')) {
        $query->where('numero_factura', 'like', '%' . $request->numero_factura . '%');
    }

    // Paginación
    $ventas = $query->paginate(10)->appends($request->all());

    return view('ventas.index', compact('ventas'));
}



    /**
     * Formulario para crear una nueva venta.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Guardar una nueva venta con múltiples productos.
     */
public function store(Request $request)
{
    // Validación de los datos
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'fecha_venta' => 'required|date',
        'productos.*.producto_id' => 'required|exists:productos,id',
        'productos.*.cantidad' => 'required|numeric|min:1',
        'productos.*.precio_unitario' => 'required|numeric|min:0',
    ]);

    \DB::beginTransaction();
    try {
        // 1️⃣ Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'fecha_venta' => $request->fecha_venta,
            'total' => 0, // se recalcula más adelante
        ]);

        $totalGeneral = 0;

        // 2️⃣ Guardar los productos en detalle_venta
        foreach ($request->productos as $producto) {
            $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
            $totalGeneral += $subtotal;

            VentaDetalle::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $subtotal, // ✅ ahora sí coincide con la BD
            ]);
                // 🔄 Descontar del inventario
                $productoModel = Producto::find($producto['producto_id']);
                $productoModel->decrement('stock', $producto['cantidad']);

                // ⚠️ Si el stock queda bajo, enviar notificación
                if ($productoModel->stock <= 24) { // <-- aquí defines el límite
                    Auth::user()->notify(new StockBajoNotification($productoModel));
                }

        }

        // 3️⃣ Actualizar total de la venta
        $venta->update(['total' => $totalGeneral]);

        \DB::commit();

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente ✅');
    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
    }
}




    /**
     * Ver detalle de una venta.
     */
    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    /**
     * Generar factura en PDF.
     */
    public function generarFactura(Venta $venta)
    {
        $factura = Factura::where('venta_id', $venta->id)->first();
        $venta = Venta::with(['detalles.producto', 'abonos'])->findOrFail($venta->id);

        $totalAbonado = $venta->abonos->sum('monto');
        $saldoPendiente = $venta->total - $totalAbonado;

        if (!$factura) {
            $numeroFactura = $this->generarNumeroFactura();

            $factura = Factura::create([
                'venta_id' => $venta->id,
                'numero'   => $numeroFactura,
            ]);
        }

        $cliente = $venta->cliente;

        $customer = new Buyer([
            'name' => $cliente->nombre,
            'custom_fields' => [
                'Email'     => $cliente->email,
                'Teléfono'  => $cliente->telefono,
                'Dirección' => $cliente->direccion,
            ],
        ]);

        $seller = new Party([
            'name' => 'Tu Empresa o Negocio',
            'custom_fields' => [
                'NIT'       => '123456789-0',
                'Dirección' => 'Chinú, Córdoba',
                'Teléfono'  => '300 123 4567',
            ]
        ]);

        $items = [];
        foreach ($venta->detalles as $detalle) {
            $items[] = InvoiceItem::make($detalle->producto->nombre)
                ->pricePerUnit($detalle->precio_unitario)
                ->quantity($detalle->cantidad)
                ->units('und');
        }

        $invoice = Invoice::make()
            ->series($factura->numero)
            ->serialNumberFormat('{SERIES}')
            ->buyer($customer)
            ->seller($seller)
            ->date(Carbon::parse($venta->fecha_venta))
            ->addItems($items)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->template('default')
            ->filename('Factura_' . Carbon::parse($venta->fecha_venta)->format('d-m-Y') . '_#' . $venta->id)
            ->notes("Gracias por su compra.\nSaldo pendiente: $saldoPendiente")
            ->currencySymbol('$')
            ->currencyCode('COP')
            ->currencyFormat('{SYMBOL} {VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',');

        $invoice->venta = $venta;

        return $invoice->stream();
    }

    /**
     * Generar un nuevo número de factura.
     */
    private function generarNumeroFactura()
    {
        $ultimo = Factura::latest('id')->first();
        $numero = $ultimo ? (int) substr($ultimo->numero, -4) + 1 : 1;
        return 'FAC-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

  public function export()
{
    $fileName = 'Ventas_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
    return Excel::download(new VentasExport, $fileName);
}
}
