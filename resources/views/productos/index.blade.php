<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Lista de productos</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">

        {{-- Botón para crear nuevo producto --}}
       @can('crear productos')
           <a href="{{ route('productos.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
           <i class="fas fa-plus mr-2"></i> Nuevo producto
           </a>
        @endcan


        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-700 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla de productos --}}
       <table class="w-full mt-6 bg-white shadow-md rounded table-auto">
    <thead class="bg-gray-200 text-gray-700 text-left">
        <tr>
            <th class="px-4 py-2">📦 Nombre</th>
            <th class="px-4 py-2">🔢 Código</th>
            <th class="px-4 py-2">💰 Precio</th>
            <th class="px-4 py-2">📊 Stock</th>
            <th class="px-4 py-2">📂 Categoría</th>
            <th class="px-4 py-2">⚙️ Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr class="border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ $producto->nombre }}</td>
                <td class="px-4 py-2">{{ $producto->codigo }}</td>
                <td class="px-4 py-2">$ {{ number_format($producto->precio, 2, ',', '.') }}</td>
                <td class="px-4 py-2">{{ $producto->stock }}</td>
                <td class="px-4 py-2">
                    <i class="fas fa-tags text-gray-500 mr-1"></i>
                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                </td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="{{ route('productos.edit', $producto) }}"
                       class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>

                    @can('eliminar productos')
    <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
            <i class="fas fa-trash-alt"></i> Eliminar
        </button>
    </form>
@endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


    </div>

@if(session('swal'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: "{{ session('swal') }}",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: '#f0fdf4', // fondo verde claro
        color: '#16a34a',      // texto verde
        iconColor: '#16a34a',  // ícono verde
        customClass: {
            popup: 'text-sm px-3 py-2 rounded-md shadow'
        }
    });
</script>
@endif
@if(session('swal_delete'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error', // 👈 Icono de error
        title: "{{ session('swal_delete') }}",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: '#fef2f2', // fondo rojo claro
        color: '#b91c1c',      // texto rojo oscuro
        iconColor: '#b91c1c',  // ícono rojo
        customClass: {
            popup: 'text-sm px-3 py-2 rounded-md shadow'
        }
    });
</script>
@endif



</x-app-layout>
