<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Carbon\Carbon;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class ReporteCompraController extends Controller
{
    public function generarPDF($id)
    {
        $compra = Compra::with(['producto','proveedor'])->findOrFail($id);

        // ✅ Item de la compra
        $item = InvoiceItem::make('Compra de: ' . $compra->producto->nombre)
            ->pricePerUnit($compra->precio_unitario)
            ->quantity($compra->cantidad);

        // ✅ Datos del proveedor
        $proveedor = new Party([
            'name'          => $compra->proveedor->nombre,
            'custom_fields' => [
                'Correo'    => $compra->proveedor->correo,
                'Teléfono'  => $compra->proveedor->telefono,
                'Dirección' => $compra->proveedor->direccion,
            ],
        ]);

        // ✅ Construcción de la factura con el proveedor
        $invoice = Invoice::make()
            ->buyer($proveedor) // el proveedor aparece como "buyer"
            ->taxRate(0)
            ->status(__('Pagado'))
            ->date(Carbon::parse($compra->fecha_compra))
            ->filename('compra_' . $compra->id)
            ->template('compras-template')
            ->addItem($item); // 👈 AQUÍ lo agregamos

        return $invoice->stream();
    }
}
