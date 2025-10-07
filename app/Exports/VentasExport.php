<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])->orderBy('fecha_venta', 'desc')->get();

        $rows = [];
        foreach ($ventas as $venta) {
            foreach ($venta->detalles as $detalle) {
                $rows[] = [
                    'ID Venta'       => $venta->id,
                    'Cliente'        => $venta->cliente ? $venta->cliente->nombre : 'N/A',
                    'Producto'       => $detalle->producto ? $detalle->producto->nombre : 'N/A',
                    'Cantidad'       => $detalle->cantidad,
                    'Precio Unitario'=> number_format($detalle->precio_unitario, 2, ',', '.'),
                    'Subtotal'       => number_format($detalle->subtotal, 2, ',', '.'),
                    'Total Venta'    => number_format($venta->total, 2, ',', '.'),
                    'Fecha de Venta' => $venta->fecha_venta->format('d/m/Y'),
                ];
            }
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'ID Venta',
            'Cliente',
            'Producto',
            'Cantidad',
            'Precio Unitario',
            'Subtotal',
            'Total Venta',
            'Fecha de Venta',
        ];
    }
}
