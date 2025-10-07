<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧾 Lista de Ventas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">

        {{-- 🔝 Barra superior --}}
        <div class="mb-4 flex flex-wrap gap-3 justify-between items-center">

            {{-- Nueva venta --}}
            <a href="{{ route('ventas.create') }}"
               class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i> Nueva venta
            </a>

            {{-- Exportar --}}
            <a href="{{ route('ventas.export', request()->query()) }}"
               class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                📥 Exportar Ventas
            </a>

        </div>

        {{-- 🔎 Filtros --}}
        <form method="GET" action="{{ route('ventas.index') }}" class="flex flex-wrap items-end gap-3 mb-4 bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">

            {{-- Cliente --}}
            <div>
                <label class="block text-sm font-medium text-gray-600">Cliente</label>
                <input type="text" name="cliente" value="{{ request('cliente') }}" placeholder="Nombre del cliente"
                       class="border border-gray-300 rounded-lg px-3 py-2 w-48 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Fecha inicio --}}
            <div>
                <label class="block text-sm font-medium text-gray-600">Fecha inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Fecha fin --}}
            <div>
                <label class="block text-sm font-medium text-gray-600">Fecha fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                       class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Número de factura --}}
            <div>
                <label class="block text-sm font-medium text-gray-600"># Factura</label>
                <input type="text" name="numero_factura" value="{{ request('numero_factura') }}" placeholder="Ej: 0001"
                       class="border border-gray-300 rounded-lg px-3 py-2 w-28 focus:ring-2 focus:ring-blue-500 focus:outline-none text-center">
            </div>

            {{-- Botones --}}
            <div class="flex gap-2 items-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-semibold transition">
                    Buscar
                </button>

                @if(request('cliente') || request('fecha_inicio') || request('fecha_fin') || request('numero_factura'))
                    <a href="{{ route('ventas.index') }}"
                       class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold transition">
                       Limpiar
                    </a>
                @endif
            </div>
        </form>

        {{-- ⚡ Alertas de éxito --}}
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
                    customClass: { popup: 'text-sm px-3 py-2 rounded-md shadow' }
                });
            </script>
        @endif

        {{-- 📊 Tabla de ventas --}}
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
                            <td class="px-4 py-2 font-semibold whitespace-nowrap text-center">
                                {{ $venta->numero_factura ?? '—' }}
                            </td>
                            <td class="px-4 py-2">{{ $venta->cliente->nombre }}</td>

                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($venta->detalles as $detalle)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-300 shadow-sm">
                                            {{ $detalle->producto->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-4 py-2">
                                @foreach($venta->detalles as $detalle)
                                    {{ $detalle->cantidad }} <br>
                                @endforeach
                            </td>

                            <td class="px-4 py-2">
                                @foreach($venta->detalles as $detalle)
                                    $ {{ number_format($detalle->precio_unitario, 2, ',', '.') }} <br>
                                @endforeach
                            </td>

                            <td class="px-4 py-2 font-semibold text-green-700">
                                $ {{ number_format($venta->total, 2, ',', '.') }}
                            </td>

                            <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>

                            <td class="px-4 py-2 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('ventas.factura', $venta->id) }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center w-28 h-8 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                        <i class="fas fa-file-pdf mr-1"></i> Ver Factura
                                    </a>
                                    <a href="{{ route('ventas.show', $venta->id) }}"
                                       class="inline-flex items-center justify-center w-28 h-8 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition">
                                        <i class="fas fa-dollar-sign mr-1"></i> Abonar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                @if(request('numero_factura'))
                                    ❌ No se encontró ninguna venta con el número de factura "{{ request('numero_factura') }}"
                                @elseif(request('cliente'))
                                    ❌ No se encontraron ventas para el cliente "{{ request('cliente') }}"
                                @elseif(request('fecha_inicio') || request('fecha_fin'))
                                    ❌ No se encontraron ventas en el rango de fechas seleccionado
                                @else
                                    ❌ No se encontraron ventas registradas
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📄 Paginación --}}
        <div class="mt-4">
            {{ $ventas->links() }}
        </div>

        {{-- ❌ Alerta de eliminación --}}
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
                    customClass: { popup: 'text-sm px-3 py-2 rounded-md shadow' }
                });
            </script>
        @endif

    </div>
</x-app-layout>
