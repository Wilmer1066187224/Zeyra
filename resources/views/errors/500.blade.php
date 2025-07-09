<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-pink-600">💥 Error 500 - Error del servidor</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 border border-pink-300 rounded shadow text-center">
        <div class="text-5xl mb-4 text-pink-500">😵</div>
        <h3 class="text-xl font-semibold text-pink-700">¡Algo salió mal en el servidor!</h3>
        <p class="mt-2 text-gray-600">
            Intenta de nuevo más tarde o contacta al administrador.
        </p>

        <a href="{{ route('dashboard') }}"
           class="mt-6 inline-block bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded transition">
            Volver al inicio
        </a>
    </div>
</x-app-layout>
