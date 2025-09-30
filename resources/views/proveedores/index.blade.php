<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 Lista de Proveedores</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4">
        <a href="{{ route('proveedores.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
            ➕ Nuevo Proveedor
        </a>

        @if(session('swal'))
            <div class="mt-4 bg-green-100 text-green-700 p-2 rounded">
                {{ session('swal') }}
            </div>
        @endif

        <table class="w-full mt-6 bg-white shadow-md rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">🏢 Nombre</th>
                    <th class="px-4 py-2">📧 Correo</th>
                    <th class="px-4 py-2">📞 Teléfono</th>
                    <th class="px-4 py-2">📍 Dirección</th>
                    <th class="px-4 py-2">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                        <td class="px-4 py-2">{{ $proveedor->correo }}</td>
                        <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                        <td class="px-4 py-2">{{ $proveedor->direccion }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('proveedores.edit', $proveedor) }}"
                               class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                               ✏️ Editar
                            </a>
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar proveedor?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
