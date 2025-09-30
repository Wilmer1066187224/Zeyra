<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Registrar nueva venta</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf

            {{-- Cliente --}}
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

            {{-- Fecha --}}
            <div class="mb-4">
                <label for="fecha_venta" class="block text-sm font-medium">Fecha de venta</label>
                <input type="date" name="fecha_venta" id="fecha_venta" class="w-full border rounded p-2"
                    value="{{ date('Y-m-d') }}">
                @error('fecha_venta') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Productos dinámicos --}}
            <div class="mb-4">
                <h3 class="text-lg font-bold mb-2">Productos</h3>
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Producto</th>
                            <th class="p-2">Cantidad</th>
                            <th class="p-2">Precio unitario</th>
                            <th class="p-2">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="productos-table">
                        <tr>
                            <td>
                                <select name="productos[0][producto_id]" class="w-full border rounded p-2">
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="productos[0][cantidad]" class="w-full border p-2 cantidad" min="1"></td>
                            <td><input type="number" step="0.01" name="productos[0][precio_unitario]" class="w-full border p-2 precio"></td>
                            <td><input type="text" class="w-full border p-2 bg-gray-100 subtotal" disabled></td>
                            <td>
                                <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add-row" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">+ Agregar producto</button>
            </div>

            {{-- Total general --}}
            <div class="mt-4 text-right">
                <label class="font-bold">💲 Total:</label>
                <input type="text" id="total-general" class="border p-2 rounded bg-gray-100 w-40 text-right" readonly>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end space-x-2 mt-4">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar venta</button>
            </div>
        </form>
    </div>

    {{-- Script para manejar productos dinámicos --}}
    <script>
        let row = 1;

        // Función para formatear con separadores de miles
        function formatNumber(num) {
            return new Intl.NumberFormat('es-CO').format(num);
        }

        // Calcular subtotal por fila
        function calcularSubtotal(rowElement) {
            const cantidad = parseFloat(rowElement.querySelector('.cantidad')?.value) || 0;
            const precio = parseFloat(rowElement.querySelector('.precio')?.value) || 0;
            const subtotalInput = rowElement.querySelector('.subtotal');

            let subtotal = cantidad * precio;
            subtotalInput.value = subtotal > 0 ? formatNumber(subtotal) : '';
            calcularTotalGeneral();
        }

        // Calcular total general
        function calcularTotalGeneral() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(sub => {
                let valor = sub.value.replace(/\./g, '').replace(',', '.');
                total += parseFloat(valor) || 0;
            });
            document.getElementById('total-general').value = total > 0 ? formatNumber(total) : '';
        }

        // Agregar filas dinámicas
        document.getElementById('add-row').addEventListener('click', function() {
            const table = document.getElementById('productos-table');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <select name="productos[${row}][producto_id]" class="w-full border rounded p-2">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="productos[${row}][cantidad]" class="w-full border p-2 cantidad" min="1"></td>
                <td><input type="number" step="0.01" name="productos[${row}][precio_unitario]" class="w-full border p-2 precio"></td>
                <td><input type="text" class="w-full border p-2 bg-gray-100 subtotal" disabled></td>
                <td><button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded">X</button></td>
            `;
            table.appendChild(newRow);
            row++;
        });

        // Detectar cambios en cantidad y precio
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
                const rowElement = e.target.closest('tr');
                calcularSubtotal(rowElement);
            }
        });

        // Eliminar fila
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
                calcularTotalGeneral();
            }
        });
    </script>
</x-app-layout>
