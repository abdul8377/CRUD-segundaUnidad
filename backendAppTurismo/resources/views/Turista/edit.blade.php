<x-layouts.app :title="__('Editar Contraseña del Turista')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Editar Contraseña para: {{ $turista->name }}</h2>

        <!-- Formulario para Editar Contraseña -->
        <form action="{{ route('turistas.update', $turista) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Botón de Guardar Cambios -->
            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Guardar Cambios
            </button>
        </form>
    </div>
</x-layouts.app>
