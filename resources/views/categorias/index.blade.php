<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Lista de categorías</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4">
        <a href="{{ route('categorias.create') }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i> Nueva categoría
        </a>

        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-700 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-6 bg-white shadow-md rounded table-auto">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $categoria->nombre }}</td>
                        <td class="px-4 py-2">{{ $categoria->descripcion }}</td>
                        <td class="px-4 py-2 space-x-2 flex">
                            <a href="{{ route('categorias.edit', $categoria) }}"
                               class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>

                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-block px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
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
