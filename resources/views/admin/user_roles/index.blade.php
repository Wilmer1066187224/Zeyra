<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">👥 Asignar Roles y Permisos</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded shadow">
        @if(session('swal'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('swal') }}
            </div>
        @endif

        <table class="w-full">
            <thead>
                <tr class="text-left bg-gray-200 text-sm text-gray-700">
                    <th class="px-4 py-2">👤 Usuario</th>
                    <th class="px-4 py-2">📛 Rol actual</th>
                    <th class="px-4 py-2">🎯 Permisos</th>
                    <th class="px-4 py-2">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b hover:bg-gray-50 text-sm">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->getRoleNames()->first() ?? 'Sin rol' }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.user-roles.update', $user) }}" method="POST">
                                @csrf
                             

                                <select name="role" class="border rounded p-1 text-sm mb-2">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-1 text-xs">
                                    @foreach($permissions as $permission)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                   {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <span class="ml-1">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <button class="mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                    💾 Guardar
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2 text-xs">
                            Total permisos: {{ $user->permissions->count() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
