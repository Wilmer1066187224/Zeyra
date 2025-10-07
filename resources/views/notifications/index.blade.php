<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🔔 Notificaciones</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 mt-6 shadow rounded">
        <h3 class="text-lg mb-4 font-semibold">📩 No leídas</h3>

        @forelse(auth()->user()->unreadNotifications as $notificacion)
            <div class="border p-3 mb-3 rounded bg-gray-50">
                <p>{{ $notificacion->data['mensaje'] ?? 'Notificación' }}</p>
                <form method="POST" action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}">
                    @csrf
                    <button type="submit" class="text-blue-600 text-sm mt-2 hover:underline">
                        ✔️ Marcar como leída
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No tienes notificaciones nuevas.</p>
        @endforelse
    </div>

    <div class="max-w-4xl mx-auto bg-white p-6 mt-6 shadow rounded">
        <h3 class="text-lg mb-4 font-semibold">📜 Todas las notificaciones</h3>

        @forelse(auth()->user()->notifications as $notificacion)
            <div class="border p-3 mb-2 rounded {{ $notificacion->read_at ? 'bg-gray-100' : 'bg-yellow-50' }}">
                <p>{{ $notificacion->data['mensaje'] ?? 'Notificación' }}</p>
                <small class="text-gray-500">
                    {{ $notificacion->created_at->diffForHumans() }}
                </small>
            </div>
        @empty
            <p class="text-gray-500">No tienes notificaciones registradas.</p>
        @endforelse
    </div>
</x-app-layout>
