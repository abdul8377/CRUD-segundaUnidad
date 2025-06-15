<x-layouts.auth.simple :title="'Iniciar sesión - Paso 2'">
    <h2 class="text-center text-3xl font-bold md:text-left md:leading-tight">
        <i class="fas fa-lock text-orange-500 mr-2"></i>Hola, {{ $userRecord->name }} {{ $userRecord->last_name }}
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 text-center md:text-left">
        Rol: <span class="font-semibold text-orange-500">{{ $userRecord->getRoleNames()->first() }}</span>
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

    <form method="POST" action="{{ route('login.authenticate', $userRecord->user) }}" class="space-y-5 pt-6">
        @csrf

        <div class="relative">
            <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
            <input id="password" name="password" type="password" placeholder="Contraseña" required
                class="pl-10 pr-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
            <i class="fas fa-eye absolute top-3 right-3 text-gray-400 cursor-pointer"
                onclick="togglePassword('password', this)"></i>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                    <i class="fas fa-question-circle mr-1"></i>¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition flex items-center justify-center text-base">
            <i class="fas fa-sign-in-alt mr-2"></i>Iniciar sesión
        </button>
    </form>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-layouts.auth.simple>
