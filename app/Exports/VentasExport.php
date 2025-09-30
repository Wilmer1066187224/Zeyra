<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VentasExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Trae ventas con cliente y producto
        return Venta::with(['cliente', 'producto'])->orderBy('fecha_venta', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Producto',
            'Cantidad',
            'Precio Unitario',
            'Total',
            'Fecha de Venta'
        ];
    }

    public function map($venta): array
    {
        return [
            $venta->id,
            $venta->cliente ? $venta->cliente->nombre : 'N/A',
            $venta->producto ? $venta->producto->nombre : 'N/A',
            $venta->cantidad,
            number_format($venta->precio_unitario, 2, ',', '.'),
            number_format($venta->total, 2, ',', '.'),
            $venta->fecha_venta->format('d/m/Y')
        ];
    }
}
