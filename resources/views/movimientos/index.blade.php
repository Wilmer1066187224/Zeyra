<!-- resources/views/movimientos/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Movimientos de Inventario</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        <a href="{{ route('movimientos.create') }}"
           class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i> Nuevo movimiento
        </a>

        {{-- Alerta tipo toast --}}
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

        <table class="w-full mt-6 bg-white shadow-md rounded table-auto">
            <thead class="bg-gray-200 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2">📦 Producto</th>
                    <th class="px-4 py-2">🔄 Tipo</th>
                    <th class="px-4 py-2">🔢 Cantidad</th>
                    <th class="px-4 py-2">📝 Descripción</th>
                    <th class="px-4 py-2">🕒 Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimientos as $movimiento)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $movimiento->producto->nombre }}</td>
                        <td class="px-4 py-2">
                            @if($movimiento->tipo === 'entrada')
                                <span class="text-green-600 font-semibold">Entrada</span>
                            @else
                                <span class="text-red-600 font-semibold">Salida</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $movimiento->cantidad }}</td>
                        <td class="px-4 py-2">{{ $movimiento->descripcion ?? '—' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-500">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
