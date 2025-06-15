<x-layouts.auth.simple :title="'Iniciar sesión - Paso 1'">
    <h2 class="text-center text-3xl font-bold md:text-left md:leading-tight">
        <i class="fas fa-sign-in-alt text-orange-500 mr-2"></i>Bienvenido
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 text-center md:text-left">
        Ingresa tu nombre de usuario para continuar
    </p>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.validate.user') }}" class="space-y-5 pt-6">
        @csrf
        <div class="relative">
            <i class="fas fa-user absolute top-3 left-3 text-gray-400"></i>
            <input id="user" name="user" type="text" placeholder="Nombre de usuario" value="{{ old('user') }}" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition flex items-center justify-center text-base">
            <i class="fas fa-arrow-right mr-2"></i>Siguiente
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400 font-medium">
        ¿Aún no tienes una cuenta?
        <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold">
            <i class="fas fa-user-plus mr-1"></i>Registrarse
        </a>
    </p>
</x-layouts.auth.simple>
