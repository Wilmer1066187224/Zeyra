
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ Registrar Cliente</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 mt-6 rounded shadow">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="telefono" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Dirección</label>
                <input type="text" name="direccion" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
