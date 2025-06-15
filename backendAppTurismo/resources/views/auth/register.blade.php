<x-layouts.auth.simple :title="'Crear cuenta'">

    <h2 class="text-center text-3xl font-bold md:text-left md:leading-tight">
        <i class="fas fa-user-plus text-orange-500 mr-2"></i>Crear una cuenta
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5 pt-6">
        @csrf

        <!-- Nombre -->
        <div class="relative">
            <i class="fas fa-user absolute top-3 left-3 text-gray-400"></i>
            <input id="name" name="name" type="text" placeholder="Nombre" value="{{ old('name') }}" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <!-- Apellido -->
        <div class="relative">
            <i class="fas fa-user-tag absolute top-3 left-3 text-gray-400"></i>
            <input id="last_name" name="last_name" type="text" placeholder="Apellido" value="{{ old('last_name') }}" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <!-- Usuario -->
        <div class="relative">
            <i class="fas fa-id-badge absolute top-3 left-3 text-gray-400"></i>
            <input id="user" name="user" type="text" placeholder="Nombre de usuario" value="{{ old('user') }}" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <!-- Email -->
        <div class="relative">
            <i class="fas fa-envelope absolute top-3 left-3 text-gray-400"></i>
            <input id="email" name="email" type="email" placeholder="Correo electrónico" value="{{ old('email') }}" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <!-- Código postal -->
        <div class="relative">
            <i class="fas fa-map-pin absolute top-3 left-3 text-gray-400"></i>
            <input id="zip_code" name="zip_code" type="text" placeholder="Código Postal" value="{{ old('zip_code') }}"
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
        </div>

        <!-- País -->
        <div class="relative">
            <i class="fas fa-globe-americas absolute top-3 left-3 text-gray-400"></i>
            <select id="country" name="country" required
                class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium">
                <option value="">Seleccione un país</option>
                @foreach ($countries as $code => $name)
                    <option value="{{ $code }}" data-flag="https://flagcdn.com/24x18/{{ strtolower($code) }}.png"
                        {{ old('country') == $code ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <img id="flag-preview" class="mt-2 h-5" src="" alt="Bandera seleccionada" style="display: none;">
        </div>

        <!-- Contraseña -->
        <div class="relative">
            <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
            <input id="password" name="password" type="password" placeholder="Contraseña" required
                class="pl-10 pr-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium"
                oninput="checkPasswordStrength(this.value)" />
            <i class="fas fa-eye absolute top-3 right-3 text-gray-400 cursor-pointer"
                onclick="togglePassword('password', this)"></i>
            <div id="strength-bar" class="password-strength mt-2"></div>
            <small id="strength-text" class="text-sm font-medium"></small>
        </div>

        <!-- Confirmar contraseña -->
        <div class="relative">
            <i class="fas fa-lock-open absolute top-3 left-3 text-gray-400"></i>
            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirmar contraseña" required
                class="pl-10 pr-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" />
            <i class="fas fa-eye absolute top-3 right-3 text-gray-400 cursor-pointer"
                onclick="togglePassword('password_confirmation', this)"></i>
        </div>

        <!-- Botón -->
        <button type="submit"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition flex items-center justify-center text-base">
            <i class="fas fa-user-plus mr-2"></i>Crear cuenta
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400 font-medium">
        ¿Ya tienes una cuenta?
        <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-semibold">
            <i class="fas fa-sign-in-alt mr-1"></i>Inicia sesión
        </a>
    </p>

</x-layouts.auth.simple>
