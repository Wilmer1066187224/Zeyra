<x-app-layout>
    <!-- Navbar superior -->
    <nav class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shadow-sm">
        <h1 class="text-xl font-bold text-gray-800">📊 Panel de Control</h1>
        <div>
            <!-- Aquí puedes poner el menú de usuario, notificaciones o logout -->
            <span class="text-sm text-gray-600">Hola, {{ auth()->user()->name }}</span>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
            <h2 class="text-lg font-semibold mb-6">Menú</h2>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('productos.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">📦 Productos</a>
                </li>
                <li>
                    <a href="{{ route('categorias.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">🗂️ Categorías</a>
                </li>
                <li>
                    <a href="{{ route('movimientos.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">🔄 Movimientos</a>
                </li>
                <li>
                    <a href="{{ route('compras.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">🧾 Compras</a>
                </li>
                <li>
                    <a href="{{ route('ventas.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">💸 Ventas</a>
                </li>
                <li>
                    <a href="{{ route('clientes.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">👤 Clientes</a>
                </li>
                <li>
                    <a href="{{ route('devoluciones.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">♻️ Devoluciones</a>
                </li>
                @role('admin')
                <li>
                    <a href="{{ route('admin.user-roles.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">👥 Roles y Permisos</a>
                </li>
                @endrole
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-6 bg-gray-50">
            <!-- Notificaciones -->
            @if (auth()->user()->unreadNotifications->count())
                <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <ul>
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <li class="mb-2 flex justify-between items-center">
                                {{ $notification->data['mensaje'] }}
                                <form action="{{ route('notificaciones.leer', $notification->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-sm text-blue-600 ml-4">✅ Marcar como leída</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tarjetas de Ventas por Día / Mes / Año -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Día -->
    <div class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 p-4 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">📅 Ventas del Día</h3>
        <p class="text-2xl font-bold">$ {{ number_format($ventas_hoy, 2, ',', '.') }}</p>
        <p class="text-sm mt-1 {{ $variacion_dia >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $variacion_dia >= 0 ? '▲' : '▼' }} {{ number_format($variacion_dia, 1) }}% respecto a ayer
        </p>
    </div>

    <!-- Mes -->
    <div class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 p-4 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">📆 Ventas del Mes</h3>
        <p class="text-2xl font-bold">$ {{ number_format($ventas_mes, 2, ',', '.') }}</p>
        <p class="text-sm mt-1 {{ $variacion_mes >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $variacion_mes >= 0 ? '▲' : '▼' }} {{ number_format($variacion_mes, 1) }}% respecto al mes pasado
        </p>
    </div>

    <!-- Año -->
    <div class="bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 p-4 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-lg font-semibold">📈 Ventas del Año</h3>
        <p class="text-2xl font-bold">$ {{ number_format($ventas_anio, 2, ',', '.') }}</p>
        <p class="text-sm mt-1 {{ $variacion_anio >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $variacion_anio >= 0 ? '▲' : '▼' }} {{ number_format($variacion_anio, 1) }}% respecto al año anterior
        </p>
    </div>
</div>


            <!-- Reporte de Inventario -->
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl font-bold mb-6">📈 Reporte de Inventario</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-green-100 text-green-800 p-4 rounded shadow">
        <h3 class="text-lg font-semibold">💰 Total Compras</h3>
        <p class="text-2xl font-bold">$ {{ number_format($total_compras ?? 0, 2, ',', '.') }}</p>
    </div>
    <div class="bg-blue-100 text-blue-800 p-4 rounded shadow">
        <h3 class="text-lg font-semibold">💵 Total Ventas</h3>
        <p class="text-2xl font-bold">$ {{ number_format($total_ventas ?? 0, 2, ',', '.') }}</p>
    </div>
</div>



                
<!-- Top 5 Clientes -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-purple-700 mb-2">👑 Top 5 Clientes que más compran</h3>
    @if($top_clientes->count())
        <table class="w-full bg-white shadow rounded">
            <thead class="bg-purple-100 text-purple-700">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Cliente</th>
                    <th class="px-4 py-2">Total Comprado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($top_clientes as $index => $cliente)
                    <tr class="border-b hover:bg-purple-50">
                        <td class="px-4 py-2 font-bold">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $cliente->nombre }}</td>
                        <td class="px-4 py-2">
                            $ {{ number_format($cliente->ventas_sum_total, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-sm text-gray-600">No hay clientes con compras registradas.</p>
    @endif
</div>

<!-- Gráficas -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <!-- Ventas -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Ventas por Mes</h3>
        <canvas id="ventasChart"></canvas>
    </div>

    <!-- Compras -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Compras por Mes</h3>
        <canvas id="comprasChart"></canvas>
    </div>
</div>



                <!-- Productos con stock crítico -->
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

                <!-- Últimos movimientos -->
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
        </main>
    </div>
</x-app-layout>
<script>
    const meses = @json($meses->values());
    const ventas = Array(12).fill(0);
    const compras = Array(12).fill(0);

    @foreach($ventas_por_mes as $mes => $total)
        ventas[{{ $mes - 1 }}] = {{ $total }};
    @endforeach

    @foreach($compras_por_mes as $mes => $total)
        compras[{{ $mes - 1 }}] = {{ $total }};
    @endforeach

    // Ventas
    new Chart(document.getElementById('ventasChart'), {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ventas',
                data: ventas,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    // Compras
    new Chart(document.getElementById('comprasChart'), {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Compras',
                data: compras,
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });
    document.querySelectorAll('.text-2xl.font-bold').forEach(el => {
    const value = parseFloat(el.textContent.replace(/[^0-9.-]+/g, ""));
    let start = 0;
    const duration = 1500;
    const step = value / (duration / 16);

    const counter = setInterval(() => {
        start += step;
        if (start >= value) {
            el.textContent = "$ " + value.toLocaleString('es-CO', { minimumFractionDigits: 2 });
            clearInterval(counter);
        } else {
            el.textContent = "$ " + Math.floor(start).toLocaleString('es-CO', { minimumFractionDigits: 2 });
        }
    }, 16);
});
</script>
