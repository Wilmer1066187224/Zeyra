<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">♻️ Historial de Devoluciones</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex justify-end mb-4">
    <a href="{{ route('devoluciones.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow">
        <i class="fas fa-undo mr-2"></i> Registrar Devolución
    </a>
</div>

            @if ($devoluciones->isEmpty())
                <div class="text-center text-gray-600">
                    <i class="fas fa-box-open text-4xl mb-2 text-gray-400"></i>
                    <p>No hay devoluciones registradas.</p>
                </div>
            @else
               <div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="w-auto mx-auto divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100 sticky top-0 z-10">
            <tr>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Cliente</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Producto Devuelto</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Producto Nuevo</th>
                <th class="px-4 py-3 text-center font-semibold text-gray-600">Cantidad</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Motivo</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Fecha</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            @foreach ($devoluciones as $devolucion)
                <tr class="hover:bg-blue-50 transition duration-150">
                    <td class="px-4 py-2">{{ $devolucion->id }}</td>
                    <td class="px-4 py-2">{{ $devolucion->venta->cliente->nombre ?? 'Cliente' }}</td>
                    <td class="px-4 py-2 text-red-600 font-medium">{{ $devolucion->productoDevuelto->nombre }}</td>
                    <td class="px-4 py-2 text-green-600 font-medium">{{ $devolucion->productoNuevo->nombre ?? 'Sin cambio' }}</td>
                    <td class="px-4 py-2 text-center">{{ $devolucion->cantidad }}</td>
                    <td class="px-4 py-2">{{ $devolucion->motivo }}</td>
                    <td class="px-4 py-2 text-gray-500">{{ $devolucion->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


            @endif
        </div>
    </div>
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2563eb', // Azul
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

</x-app-layout>
