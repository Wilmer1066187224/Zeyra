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
        // Totales
        $total_compras = Compra::sum('total');
        $total_ventas  = Venta::sum('total');

        // Productos con bajo stock
        $productos_bajo_stock = Producto::whereColumn('stock', '<=', 'stock_minimo')->get();

        // Últimos movimientos
        $ultimos_movimientos = Movimiento::with('producto')->latest()->take(5)->get();

        // Top clientes
        $top_clientes = Cliente::withSum('ventas', 'total')
            ->orderByDesc('ventas_sum_total')
            ->take(5)
            ->get();

        // Fechas actuales
        $hoy = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $inicioAnio = Carbon::now()->startOfYear();

        // Ventas por día, mes y año
        $ventas_dia = Venta::whereDate('created_at', $hoy)->sum('total');
        $ventas_mes = Venta::whereBetween('created_at', [$inicioMes, Carbon::now()])->sum('total');
        $ventas_anio = Venta::whereBetween('created_at', [$inicioAnio, Carbon::now()])->sum('total');

        // Comparativas
        $ventas_dia_anterior = Venta::whereDate('created_at', Carbon::yesterday())->sum('total');
        $ventas_mes_anterior = Venta::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('total');
        $ventas_anio_anterior = Venta::whereYear('created_at', Carbon::now()->subYear()->year)->sum('total');

        // Calcular variaciones
        $variacion_dia = $ventas_dia_anterior > 0 ? (($ventas_dia - $ventas_dia_anterior) / $ventas_dia_anterior) * 100 : 0;
        $variacion_mes = $ventas_mes_anterior > 0 ? (($ventas_mes - $ventas_mes_anterior) / $ventas_mes_anterior) * 100 : 0;
        $variacion_anio = $ventas_anio_anterior > 0 ? (($ventas_anio - $ventas_anio_anterior) / $ventas_anio_anterior) * 100 : 0;

        // Alias para compatibilidad con la vista
        $ventas_hoy = $ventas_dia;

        // Ventas y compras por mes para gráficas
        $ventas_por_mes = Venta::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $compras_por_mes = Compra::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Meses traducidos
        $meses = collect(range(1, 12))->map(fn($m) => ucfirst(Carbon::create()->month($m)->translatedFormat('F')));

        return view('dashboard', compact(
            'total_compras',
            'total_ventas',
            'productos_bajo_stock',
            'ultimos_movimientos',
            'top_clientes',
            'ventas_dia',
            'ventas_mes',
            'ventas_anio',
            'variacion_dia',
            'variacion_mes',
            'variacion_anio',
            'ventas_hoy',
            'ventas_por_mes',
            'compras_por_mes',
            'meses'
        ));
    }

}
