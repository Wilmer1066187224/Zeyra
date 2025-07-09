<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Editar categoría</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="w-full border rounded p-2" value="{{ old('nombre', $categoria->nombre) }}">
                @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="w-full border rounded p-2">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('categorias.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
