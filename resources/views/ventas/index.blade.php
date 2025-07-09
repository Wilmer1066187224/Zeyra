<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧾 Lista de Ventas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        <a href="{{ route('ventas.create') }}"
           class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i> Nueva venta
        </a>

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
                    <th class="px-4 py-2">🔢 Cantidad</th>
                    <th class="px-4 py-2">💰 Precio unitario</th>
                    <th class="px-4 py-2">💲 Total</th>
                    <th class="px-4 py-2">📅 Fecha</th>
                    <th class="px-4 py-2">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $venta->producto->nombre }}</td>
                        <td class="px-4 py-2">{{ $venta->cantidad }}</td>
                        <td class="px-4 py-2">$ {{ number_format($venta->precio_unitario, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">$ {{ number_format($venta->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $venta->fecha_venta }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('ventas.destroy', $venta) }}" method="POST" onsubmit="return confirm('¿Eliminar venta?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
