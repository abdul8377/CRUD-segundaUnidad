<x-layouts.app :title="__('Crear Emprendimiento')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Crear Nuevo Emprendimiento</h2>

        <!-- Formulario -->
        <form action="{{ route('emprendimientos.store', $user->id) }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nombre del Emprendimiento -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Emprendimiento</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                    required>
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Tipo de Negocio -->
            <div>
                <label for="tipo_negocio_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Negocio</label>
                <select name="tipo_negocio_id" id="tipo_negocio_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
                    @foreach ($tiposDeNegocio as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_negocio_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_negocio_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-gray-300 dark:border-neutral-700">

            <!-- Información del Usuario -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Información del Usuario</h3>

            <!-- Usuario -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usuario</label>
                <input type="text" value="{{ $user->name }}" disabled
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('emprendedores.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    Crear Emprendimiento
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
