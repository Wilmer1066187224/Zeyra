<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📥 Lista de Compras</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        <a href="{{ route('compras.create') }}"
           class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i> Nueva compra
        </a>
     

        @if(session('swal'))
            <div class="mt-4 bg-green-100 text-green-700 p-2 rounded">
                {{ session('swal') }}
            </div>
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
                @foreach($compras as $compra)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $compra->producto->nombre ?? 'Sin producto' }}</td>
                        <td class="px-4 py-2">{{ $compra->cantidad }}</td>
                        <td class="px-4 py-2">$ {{ number_format($compra->precio_unitario, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">$ {{ number_format($compra->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $compra->fecha_compra }}</td>
                        <td class="px-4 py-2 flex space-x-2">
    <a href="{{ route('compras.pdf', $compra->id) }}"
       class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
       <i class="fas fa-file-pdf mr-1"></i> PDF
    </a>

    <form action="{{ route('compras.destroy', $compra) }}" method="POST" onsubmit="return confirm('¿Eliminar compra?')">
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
    </div>
</x-app-layout>
