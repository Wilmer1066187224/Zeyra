<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📈 Reporte de Inventario</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-green-100 text-green-800 p-4 rounded shadow">
                <h3 class="text-lg font-semibold">💰 Total Compras</h3>
                <p class="text-2xl font-bold">$ {{ number_format($total_compras, 2, ',', '.') }}</p>
            </div>
            <div class="bg-blue-100 text-blue-800 p-4 rounded shadow">
                <h3 class="text-lg font-semibold">💵 Total Ventas</h3>
                <p class="text-2xl font-bold">$ {{ number_format($total_ventas, 2, ',', '.') }}</p>
            </div>
        </div>

        {{-- Productos con stock mínimo o inferior --}}
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-red-600 mb-2">⚠️ Productos con stock crítico</h3>
            @if($productos_bajo_stock->count())
                <table class="w-full bg-white shadow rounded">
                    <thead class="bg-red-100 text-red-700">
                        <tr>
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Stock mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos_bajo_stock as $producto)
                            <tr class="border-b hover:bg-red-50">
                                <td class="px-4 py-2">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2">{{ $producto->stock }}</td>
                                <td class="px-4 py-2">{{ $producto->stock_minimo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-600">✅ Todos los productos están por encima del stock mínimo.</p>
            @endif
        </div>

        {{-- Últimos movimientos --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">📦 Últimos movimientos</h3>
            <table class="w-full bg-white shadow rounded">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimos_movimientos as $movimiento)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $movimiento->producto->nombre }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs {{ $movimiento->tipo === 'entrada' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                    {{ ucfirst($movimiento->tipo) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $movimiento->cantidad }}</td>
                            <td class="px-4 py-2">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
