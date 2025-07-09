<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-red-600">🚫 Acceso Denegado</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 bg-white border border-red-200 p-6 rounded-lg shadow-md text-center">
        <div class="text-5xl mb-4 text-red-500">⚠️</div>
        <h3 class="text-xl font-semibold text-red-600">¡Oops! No tienes permiso para acceder a esta sección.</h3>
        <p class="mt-2 text-gray-600">Por favor, contacta con un administrador si crees que esto es un error.</p>

        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
            Volver al inicio
        </a>
    </div>
</x-app-layout>
