<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Devolución
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Mensajes de error --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="mb-0 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('devoluciones.store') }}" method="POST">
                    @csrf

                    {{-- Venta --}}
                    <div class="mb-4">
                        <label for="venta_id" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Venta:</label>
                        <select name="venta_id" class="form-input w-full mt-1" required>
                            <option value="">Seleccione una venta</option>
                            @foreach($ventas as $venta)
                                <option value="{{ $venta->id }}">
                                    #{{ $venta->id }} - {{ $venta->cliente->nombre ?? 'Cliente' }} - {{ $venta->fecha_venta }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Producto devuelto --}}
                    <div class="mb-4">
                        <label for="producto_devuelto_id" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Producto devuelto:</label>
                        <select name="producto_devuelto_id" class="form-input w-full mt-1" required>
                            <option value="">Seleccione el producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Producto nuevo --}}
                    <div class="mb-4">
                        <label for="producto_nuevo_id" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Producto nuevo (opcional):</label>
                        <select name="producto_nuevo_id" class="form-input w-full mt-1">
                            <option value="">Sin cambio de producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Cantidad --}}
                    <div class="mb-4">
                        <label for="cantidad" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Cantidad:</label>
                        <input type="number" name="cantidad" min="1" required class="form-input w-full mt-1">
                    </div>

                    {{-- Motivo --}}
                    <div class="mb-4">
                        <label for="motivo" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Motivo:</label>
                        <input type="text" name="motivo" class="form-input w-full mt-1">
                    </div>

                    {{-- Botón --}}
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Registrar devolución
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
