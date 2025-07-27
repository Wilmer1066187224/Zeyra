<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            💳 Detalles de Venta #{{ $venta->id }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-xl p-6 space-y-6">

            {{-- Información general --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">🧾 Información de la Venta</h3>
                <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
                <p><strong>Producto:</strong> {{ $venta->producto->nombre }}</p>
                <p><strong>Cantidad:</strong> {{ $venta->cantidad }}</p>
                <p><strong>Precio Unitario:</strong> ${{ number_format($venta->precio_unitario, 2) }}</p>
                <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
                <p><strong>Fecha de venta:</strong> {{ $venta->fecha_venta }}</p>
            </div>

            {{-- Resumen financiero --}}
            <div class="bg-gray-50 p-4 rounded-md border">
                <p><strong>Total abonado:</strong> <span class="text-green-600">${{ number_format($venta->total_abonado, 2) }}</span></p>
                <p><strong>Saldo pendiente:</strong>
                    <span class="{{ $venta->saldo_pendiente > 0 ? 'text-red-600' : 'text-green-700' }}">
                        ${{ number_format($venta->saldo_pendiente, 2) }}
                    </span>
                </p>
            </div>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Registrar abono --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">💵 Registrar Abono</h3>
                <form action="{{ route('abonos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="venta_id" value="{{ $venta->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Monto</label>
                        <input type="number" name="monto" required min="1" step="0.01"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Método de pago</label>
                        <input type="text" name="metodo_pago" placeholder="Ej: Efectivo, Nequi, Bancolombia"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha del abono</label>
                        <input type="date" name="fecha_abono"
                            value="{{ now()->format('Y-m-d') }}"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        Registrar Abono
                    </button>
                </form>
            </div>

            {{-- Historial de abonos --}}
            @if($venta->abonos->count())
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">📄 Historial de Abonos</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200 border border-gray-200 rounded-md">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Monto</th>
                                    <th class="px-4 py-2 text-left">Método</th>
                                    <th class="px-4 py-2 text-left">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($venta->abonos as $abono)
                                    <tr class="hover:bg-blue-50">
                                        <td class="px-4 py-2">${{ number_format($abono->monto, 2) }}</td>
                                        <td class="px-4 py-2">{{ $abono->metodo_pago }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($abono->fecha_abono)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
