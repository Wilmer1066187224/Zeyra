<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Registrar movimiento</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('movimientos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="producto_id" class="block text-sm font-medium">Producto</label>
                <select name="producto_id" id="producto_id" class="w-full border rounded p-2">
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                        </option>
                    @endforeach
                </select>
                @error('producto_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium">Tipo de movimiento</label>
                <select name="tipo" id="tipo" class="w-full border rounded p-2">
                    <option value="">Seleccione el tipo</option>
                    <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
                @error('tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="w-full border rounded p-2" value="{{ old('cantidad') }}">
                @error('cantidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="motivo" class="block text-sm font-medium">Motivo (opcional)</label>
                <textarea name="motivo" id="motivo" class="w-full border rounded p-2">{{ old('motivo') }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('movimientos.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar movimiento</button>
            </div>
        </form>
    </div>
</x-app-layout>