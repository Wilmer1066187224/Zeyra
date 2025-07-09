<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 Lista de Clientes</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <div class="flex justify-end mb-4">
            <a href="{{ route('clientes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                ➕ Nuevo Cliente
            </a>
        </div>

        @if (session('swal'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('swal') }}
            </div>
        @endif

        <table class="w-full text-sm text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">👤 Nombre</th>
                    <th class="px-4 py-2">📧 Email</th>
                    <th class="px-4 py-2">📱 Teléfono</th>
                    <th class="px-4 py-2">🏠 Dirección</th>
                    <th class="px-4 py-2">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $cliente->nombre }}</td>
                        <td class="px-4 py-2">{{ $cliente->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $cliente->telefono ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $cliente->direccion ?? '-' }}</td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="#" class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">Editar</a>
                            <form action="#" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
