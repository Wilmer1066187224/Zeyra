<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Registrar nueva venta</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf
             <div class="mb-4">
               <label for="cliente_id" class="block text-sm font-medium">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="w-full border rounded p-2">
                  <option value="">Seleccione un cliente</option>
               @foreach($clientes as $cliente)
                      <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
               @endforeach
               </select>
                @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="producto_id" class="block text-sm font-medium">Producto</label>
                <select name="producto_id" id="producto_id" class="w-full border rounded p-2">
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
                @error('producto_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="w-full border rounded p-2" min="1">
                @error('cantidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="precio_unitario" class="block text-sm font-medium">Precio unitario</label>
                <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="w-full border rounded p-2">
                @error('precio_unitario') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="fecha_venta" class="block text-sm font-medium">Fecha de venta</label>
                <input type="date" name="fecha_venta" id="fecha_venta" class="w-full border rounded p-2" value="{{ date('Y-m-d') }}">
                @error('fecha_venta') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar venta</button>
            </div>
        </form>
    </div>
</x-app-layout>
