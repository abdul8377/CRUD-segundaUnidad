<x-layouts.auth.simple :title="'Restablecer Contraseña'">

    <h2 class="text-center text-3xl font-bold md:text-left md:leading-tight mb-6">
        <i class="fas fa-key text-orange-500 mr-2"></i>Restablecer Contraseña
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5 pt-2">
        @csrf

        <!-- Token oculto -->
        <input type="hidden" name="token" value="{{ $token }}" />
        <!-- Email oculto -->
        <input type="hidden" name="email" value="{{ request('email') }}" />

        <!-- Nueva Contraseña -->
        <div class="relative">
            <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Nueva contraseña"
                required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium"
                autocomplete="new-password"
            />
        </div>

        <!-- Confirmar Nueva Contraseña -->
        <div class="relative">
            <i class="fas fa-lock-open absolute top-3 left-3 text-gray-400"></i>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                placeholder="Confirmar nueva contraseña"
                required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium"
                autocomplete="new-password"
            />
        </div>

        <!-- Botón -->
        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition flex items-center justify-center text-base">
            <i class="fas fa-key mr-2"></i>Restablecer Contraseña
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400 font-medium">
        ¿Recordaste tu contraseña?
        <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-semibold">
            <i class="fas fa-sign-in-alt mr-1"></i>Inicia sesión
        </a>
    </p>

</x-layouts.auth.simple>
