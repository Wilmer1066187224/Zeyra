<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧾 Lista de Ventas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        {{-- Botón Nueva Venta --}}
        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('ventas.create') }}"
               class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i> Nueva venta
            </a>

            {{-- Filtro por cliente --}}
            <form method="GET" action="{{ route('ventas.index') }}" class="flex space-x-2">
               <input type="text" name="cliente" placeholder="Buscar por cliente"
    value="{{ request('cliente') }}"
    class="border p-2 rounded w-2/3" />


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

        {{-- Tabla de Ventas --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white shadow-md rounded table-auto">
                <thead class="bg-gray-200 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2">👤 Cliente</th>
                        <th class="px-4 py-2">📦 Producto</th>
                        <th class="px-4 py-2">🔢 Cantidad</th>
                        <th class="px-4 py-2">💰 Precio unitario</th>
                        <th class="px-4 py-2">💲 Total</th>
                        <th class="px-4 py-2">📅 Fecha</th>
                        <th class="px-4 py-2 text-center">⚙️ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr class="border-b hover:bg-gray-100 text-sm">
                            <td class="px-4 py-2">{{ $venta->cliente->nombre }}</td>
                            <td class="px-4 py-2">{{ $venta->producto->nombre }}</td>
                            <td class="px-4 py-2">{{ $venta->cantidad }}</td>
                            <td class="px-4 py-2">$ {{ number_format($venta->precio_unitario, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">$ {{ number_format($venta->total, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>
                            <td class="px-4 py-2 space-x-1 text-center">
                                {{-- Botón Factura --}}
                                <a href="{{ route('ventas.factura', $venta->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-file-pdf mr-1"></i> Ver Factura
                                </a>

                                {{-- Botón Abonar --}}
                                <a href="{{ route('ventas.show', $venta->id) }}" 
                                   class="inline-flex items-center px-2 py-1 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition">
                                    <i class="fas fa-dollar-sign mr-1"></i> Abonar
                                </a>

                                {{-- Botón Eliminar --}}
                                <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('¿Eliminar venta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
