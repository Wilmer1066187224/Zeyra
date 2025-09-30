<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Proveedor</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
    @csrf
    @method('PUT')


            <div class="mb-4">
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" value="{{ $proveedor->nombre }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Correo</label>
                <input type="email" name="correo" class="w-full border rounded p-2" value="{{ $proveedor->correo }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="telefono" class="w-full border rounded p-2" value="{{ $proveedor->telefono }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Dirección</label>
                <input type="text" name="direccion" class="w-full border rounded p-2" value="{{ $proveedor->direccion }}">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('proveedores.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
