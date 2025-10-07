<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative">
        <!-- Fondo con imagen + overlay morado -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                 alt="Fondo"
                 class="w-full h-full object-cover" />
            <!-- Overlay morado translúcido -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/80 via-purple-500/70 to-pink-400/70 backdrop-blur-sm"></div>
        </div>

        <!-- Tarjeta del login -->
        <div class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/30">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-8 w-8 text-white" 
                         fill="none" 
                         viewBox="0 0 24 24" 
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zM16 11c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zM12 17c-2.21 0-4 1.343-4 3h8c0-1.657-1.79-3-4-3z" />
                    </svg>
                </div>
            </div>

            <!-- Título -->
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Bienvenido a <span class="text-indigo-600">Mi Sistema</span>
            </h2>
            <p class="mt-2 text-center text-gray-600 text-sm">
                Ingresa tus credenciales para continuar
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-green-600" :status="session('status')" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 shadow-sm"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 shadow-sm"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Opciones -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
                            name="remember">
                        <span class="ml-2">Recuérdame</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-indigo-600 hover:underline"
                            href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón -->
                <div>
                    <x-primary-button
                        class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold rounded-lg shadow-lg transition ease-in-out duration-200">
                        {{ __('Ingresar') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Registro -->
            <p class="text-center mt-6 text-sm text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
