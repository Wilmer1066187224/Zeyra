<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-yellow-600">🔍 Error 404 - Página no encontrada</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 border border-yellow-300 rounded shadow text-center">
        <div class="text-5xl mb-4 text-yellow-500">😕</div>
        <h3 class="text-xl font-semibold text-yellow-700">¡Ups! La página que buscas no existe.</h3>
        <p class="mt-2 text-gray-600">
            Verifica la URL o regresa al panel principal.
        </p>

        <a href="{{ route('dashboard') }}"
           class="mt-6 inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded transition">
            Ir al Dashboard
        </a>
    </div>
</x-app-layout>
