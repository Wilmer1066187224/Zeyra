<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🔔 Notificaciones</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 mt-6 shadow rounded">
        <h3 class="text-lg mb-4">No leídas</h3>
        @forelse(auth()->user()->unreadNotifications as $notificacion)
            <div class="border p-3 mb-2">
                {{ $notificacion->data['mensaje'] ?? 'Notificación' }}
                <form method="POST" action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}">
                    @csrf
                    <button type="submit" class="text-blue-600 text-sm mt-1">Marcar como leída</button>
                </form>
            </div>
        @empty
            <p>No tienes notificaciones nuevas.</p>
        @endforelse
    </div>
</x-app-layout>
