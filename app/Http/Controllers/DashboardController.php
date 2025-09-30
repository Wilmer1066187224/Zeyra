<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
 public function index()
{
    $total_compras = \App\Models\Compra::sum('total');
    $total_ventas  = \App\Models\Venta::sum('total');
    $productos_bajo_stock = \App\Models\Producto::whereColumn('stock', '<=', 'stock_minimo')->get();
    $ultimos_movimientos = \App\Models\Movimiento::with('producto')->latest()->take(5)->get();

    $top_clientes = \App\Models\Cliente::withSum('ventas', 'total')
        ->orderByDesc('ventas_sum_total')
        ->take(5)
        ->get();

    // 🔥 Ventas de los últimos 6 meses
    $ventas_por_mes = \App\Models\Venta::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
        ->groupBy('mes')
        ->orderBy('mes')
        ->pluck('total', 'mes');

    // 🔥 Compras de los últimos 6 meses
    $compras_por_mes = \App\Models\Compra::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
        ->groupBy('mes')
        ->orderBy('mes')
        ->pluck('total', 'mes');

    // Meses traducidos
    $meses = collect(range(1,12))->map(fn($m) => Carbon::create()->month($m)->translatedFormat('F'));
    


    return view('dashboard', compact(
        'total_compras',
        'total_ventas',
        'productos_bajo_stock',
        'ultimos_movimientos',
        'top_clientes',
        'ventas_por_mes',
        'compras_por_mes',
        'meses'
    ));
}
}
