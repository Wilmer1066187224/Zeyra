<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">📊 Panel de Control</h2>
    </x-slot>

    <div class="py-8 px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <!-- Tarjeta de Productos -->
        <a href="{{ route('productos.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-blue-50">
            <div class="text-4xl mb-2">📦</div>
            <h3 class="text-lg font-semibold text-gray-800">Productos</h3>
            <p class="text-sm text-gray-500">Gestión de productos</p>
        </a>

        <!-- Tarjeta de Categorías -->
        <a href="{{ route('categorias.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-green-50">
            <div class="text-4xl mb-2">🗂️</div>
            <h3 class="text-lg font-semibold text-gray-800">Categorías</h3>
            <p class="text-sm text-gray-500">Organiza los productos</p>
        </a>

        <!-- Tarjeta de Movimientos -->
        <a href="{{ route('movimientos.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-yellow-50">
            <div class="text-4xl mb-2">🔄</div>
            <h3 class="text-lg font-semibold text-gray-800">Movimientos</h3>
            <p class="text-sm text-gray-500">Entradas y salidas</p>
        </a>

        <!-- Tarjeta de Compras -->
        <a href="{{ route('compras.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-indigo-50">
            <div class="text-4xl mb-2">🧾</div>
            <h3 class="text-lg font-semibold text-gray-800">Compras</h3>
            <p class="text-sm text-gray-500">Registro de compras</p>
        </a>

        <!-- Tarjeta de Ventas -->
        <a href="{{ route('ventas.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-red-50">
            <div class="text-4xl mb-2">💸</div>
            <h3 class="text-lg font-semibold text-gray-800">Ventas</h3>
            <p class="text-sm text-gray-500">Registro de ventas</p>
        </a>
        @role('admin')
    <a href="{{ route('admin.user-roles.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-purple-50">
        <div class="text-4xl mb-2">👥</div>
        <h3 class="text-lg font-semibold text-gray-800">Roles y Permisos</h3>
        <p class="text-sm text-gray-500">Gestión de acceso de usuarios</p>
    </a>
    @endrole

                <!-- Tarjeta de Clientes -->
            <a href="{{ route('clientes.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-teal-50">
                <div class="text-4xl mb-2">👤</div>
                <h3 class="text-lg font-semibold text-gray-800">Clientes</h3>
                <p class="text-sm text-gray-500">Gestión de clientes</p>
            </a>
@if (auth()->user()->unreadNotifications->count())
    <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
        <ul>
            @foreach (auth()->user()->unreadNotifications as $notification)
                <li class="mb-2 flex justify-between items-center">
                    {{ $notification->data['mensaje'] }}
                    <form action="{{ route('notificaciones.leer', $notification->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="text-sm text-blue-600 ml-4">✅ Marcar como leída</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif
<!-- Tarjeta de Devoluciones -->
<a href="{{ route('devoluciones.index') }}" class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6 text-center hover:bg-pink-50">
    <div class="text-4xl mb-2">♻️</div>
    <h3 class="text-lg font-semibold text-gray-800">Devoluciones</h3>
    <p class="text-sm text-gray-500">Ver y registrar devoluciones</p>
</a>




    </div>
</x-app-layout>
