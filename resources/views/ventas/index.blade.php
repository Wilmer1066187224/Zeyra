<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧾 Lista de Ventas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        {{-- Barra superior --}}
        <div class="mb-4 flex flex-wrap gap-3 justify-between items-center">
            {{-- Nueva venta --}}
            <a href="{{ route('ventas.create') }}"
               class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i> Nueva venta
            </a>

            {{-- Exportar --}}
            <a href="{{ route('ventas.export') }}"
               class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                📥 Exportar Ventas
            </a>

            {{-- Filtro por fechas --}}
            <form method="GET" action="{{ route('ventas.index') }}" class="flex flex-wrap gap-2">
                <input type="date" name="fecha_inicio" 
                    value="{{ request('fecha_inicio') ?? '' }}"
                    class="border p-2 rounded" />

                <input type="date" name="fecha_fin" 
                    value="{{ request('fecha_fin') ?? '' }}"
                    class="border p-2 rounded" />

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Buscar
                </button>

                @if(request('fecha_inicio') || request('fecha_fin'))
                    <a href="{{ route('ventas.index') }}" 
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                        Limpiar
                    </a>
                @endif
            </form>

            {{-- Filtro por cliente --}}
            <form method="GET" action="{{ route('ventas.index') }}" class="flex flex-wrap gap-2">
                <input type="text" name="cliente" placeholder="Buscar por cliente"
                    value="{{ request('cliente') }}"
                    class="border p-2 rounded w-64" />

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Buscar
                </button>
            </form>
        </div>

        {{-- Alerta de creación --}}
        @if(session('swal'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: "{{ session('swal') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#f0fdf4',
                    color: '#16a34a',
                    iconColor: '#16a34a',
                    customClass: {
                        popup: 'text-sm px-3 py-2 rounded-md shadow'
                    }
                });
            </script>
        @endif

        {{-- Tabla de ventas --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white shadow-md rounded table-auto text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2"># Factura</th>
                        <th class="px-4 py-2">👤 Cliente</th>
                        <th class="px-4 py-2">📦 Producto(s)</th>
                        <th class="px-4 py-2">🔢 Cantidad</th>
                        <th class="px-4 py-2">💰 Precio unitario</th>
                        <th class="px-4 py-2">💲 Total</th>
                        <th class="px-4 py-2">📅 Fecha</th>
                        <th class="px-4 py-2 text-center">⚙️ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2 font-semibold">
                                {{ $venta->numero_factura ?? '—' }}
                            </td>
                            <td class="px-4 py-2">{{ $venta->cliente->nombre }}</td>
                            
                            {{-- Productos --}}
                            <td class="px-4 py-2">
                                @foreach($venta->detalles as $detalle)
                                    • {{ $detalle->producto->nombre }} <br>
                                @endforeach
                            </td>

                            {{-- Cantidades --}}
                            <td class="px-4 py-2">
                                @foreach($venta->detalles as $detalle)
                                    {{ $detalle->cantidad }} <br>
                                @endforeach
                            </td>

                            {{-- Precios unitarios --}}
                            <td class="px-4 py-2">
                                @foreach($venta->detalles as $detalle)
                                    $ {{ number_format($detalle->precio_unitario, 2, ',', '.') }} <br>
                                @endforeach
                            </td>

                            {{-- Total --}}
                            <td class="px-4 py-2 font-semibold text-green-700">
                                $ {{ number_format($venta->total, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>

                            {{-- Acciones --}}
                            <td class="px-4 py-2 space-y-1 text-center">
                                <a href="{{ route('ventas.factura', $venta->id) }}"
                                target="_blank"
                                class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-file-pdf mr-1"></i> Ver Factura
                                </a>
                                <a href="{{ route('ventas.show', $venta->id) }}"
                                class="inline-flex items-center px-2 py-1 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition">
                                    <i class="fas fa-dollar-sign mr-1"></i> Abonar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                No se encontraron ventas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $ventas->links() }}
        </div>

        {{-- Alerta de eliminación --}}
        @if(session('swal_delete'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'error',
                    title: "{{ session('swal_delete') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#fef2f2',
                    color: '#b91c1c',
                    iconColor: '#b91c1c',
                    customClass: {
                        popup: 'text-sm px-3 py-2 rounded-md shadow'
                    }
                });
            </script>
        @endif
    </div>
</x-app-layout>
