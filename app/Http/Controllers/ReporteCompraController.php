<?php

namespace App\Http\Controllers;


use App\Models\Compra;
use Carbon\Carbon;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class ReporteCompraController extends Controller
{
  public function generarPDF($id)
    {
        $compra = Compra::with('producto')->findOrFail($id);

        $cliente = new Buyer([
            'name'          => 'Proveedor Genérico',
            'custom_fields' => [
                'Correo' => 'proveedor@email.com',
            ],
        ]);

        $item = (new InvoiceItem())
            ->title('Compra de: ' . $compra->producto->nombre)
            ->pricePerUnit($compra->precio_unitario)
            ->quantity($compra->cantidad)
            ->discount(0);

        $invoice = Invoice::make()
            ->buyer($cliente)
            ->taxRate(0)
            ->addItem($item)
            ->status('Pagado')
            ->date(Carbon::parse($compra->fecha_compra))
            ->filename('compra_' . $compra->id);

        return $invoice->stream();
    }
}
