<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Crear nuevo producto</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" class="w-full border rounded p-2" value="{{ old('nombre') }}">
                @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="codigo" class="block text-sm font-medium">Código (SKU)</label>
                <input type="text" name="codigo" id="codigo" class="w-full border rounded p-2" value="{{ old('codigo') }}">
                @error('codigo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="w-full border rounded p-2">{{ old('descripcion') }}</textarea>
            </div>
                   <div class="mb-4">
    <label for="categoria_id" class="block text-sm font-medium">Categoría</label>
    <select name="categoria_id" id="categoria_id" class="w-full border rounded p-2">
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
    @error('categoria_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>




            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" class="w-full border rounded p-2" value="{{ old('precio') }}">
                @error('precio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium">Cantidad en stock</label>
                <input type="number" name="stock" id="stock" class="w-full border rounded p-2" value="{{ old('stock') }}">
                @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="stock_minimo" class="block text-sm font-medium">Stock mínimo</label>
                <input type="number" name="stock_minimo" id="stock_minimo" class="w-full border rounded p-2" value="{{ old('stock_minimo') }}">
                @error('stock_minimo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar producto</button>

            </div>
        </form>
    </div>
</x-app-layout>
