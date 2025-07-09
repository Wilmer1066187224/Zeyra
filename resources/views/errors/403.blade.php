<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-red-600">🚫 Error 403 - Acceso Prohibido</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 border border-red-300 rounded shadow text-center">
        <div class="text-5xl mb-4 text-red-500">🛑</div>
        <h3 class="text-xl font-semibold text-red-700">¡No tienes permisos para ver esta página!</h3>
        <p class="mt-2 text-gray-600">
            Es posible que no tengas los permisos necesarios o que esta sección sea solo para administradores.
        </p>

        <a href="{{ route('dashboard') }}"
           class="mt-6 inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition">
            Volver al Inicio
        </a>
    </div>
</x-app-layout>
