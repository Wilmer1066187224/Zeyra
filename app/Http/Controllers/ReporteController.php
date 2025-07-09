<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Compra;
use App\Models\Venta;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Http\Request;

class ReporteController extends Controller
{


public function inventario()
{
    $productos = Producto::with('categoria')->get();
    $productos_bajo_stock = Producto::whereColumn('stock', '<=', 'stock_minimo')->get();

    $total_compras = Compra::sum('total');
    $total_ventas = Venta::sum('total');

    $ultimos_movimientos = Movimiento::latest()->take(10)->get();

    return view('reportes.inventario', compact(
        'productos',
        'productos_bajo_stock',
        'total_compras',
        'total_ventas',
        'ultimos_movimientos'
    ));
}
public function descargarReporte()
{
    $cliente = new Party([
        'name'          => 'Nombre de tu empresa',
        'custom_fields' => [
            'Reporte generado' => now()->format('Y-m-d H:i'),
        ],
    ]);

    $items = [];

    $compras = \App\Models\Compra::with('producto')->get();

    foreach ($compras as $compra) {
        $items[] = (new InvoiceItem())
            ->title($compra->producto->nombre)
            ->pricePerUnit($compra->precio_unitario)
            ->quantity($compra->cantidad)
            ->subTotal($compra->precio_unitario * $compra->cantidad);
    }

    $invoice = Invoice::make()
        ->buyer($cliente)
        ->series('REPO')
        ->status('Reporte')
        ->date(now())
        ->filename('reporte_compras')
        ->addItems($items);

    return $invoice->stream(); // Puedes usar ->download() si prefieres
}


}
