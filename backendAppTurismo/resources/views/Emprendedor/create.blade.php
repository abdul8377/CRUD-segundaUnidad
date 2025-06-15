<x-layouts.app :title="__('Crear Emprendedor')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Crear Nuevo Emprendedor</h2>

        <!-- Formulario -->
        <form action="{{ route('emprendedores.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellido -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('last_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre de Usuario -->
            <div>
                <label for="user" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de Usuario</label>
                <input type="text" name="user" id="user" value="{{ old('user') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('user')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Código Postal -->
            <div>
                <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código Postal</label>
                <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
                @error('zip_code')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- País -->
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">País</label>
                <select name="country" id="country"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                >
                    <option value="">Seleccione un país</option>
                    @foreach ($countries as $code => $name)
                        <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
            </div>

            <!-- Línea separadora -->
            <hr class="my-6 border-gray-300 dark:border-neutral-700">

            <!-- Sección de perfil del emprendedor -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Perfil del Emprendedor</h3>

            <!-- DNI -->
            <div>
                <label for="dni" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DNI</label>
                <input type="text" name="dni" id="dni" value="{{ old('dni') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('dni')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono de Contacto -->
            <div>
                <label for="telefono_contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono de Contacto</label>
                <input type="text" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Gmail de Contacto -->
            <div>
                <label for="gmail_contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Gmail de Contacto</label>
                <input type="email" name="gmail_contacto" id="gmail_contacto" value="{{ old('gmail_contacto') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Experiencia -->
            <div>
                <label for="experiencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Experiencia</label>
                <textarea name="experiencia" id="experiencia" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">{{ old('experiencia') }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('emprendedores.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    Crear Emprendedor
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
