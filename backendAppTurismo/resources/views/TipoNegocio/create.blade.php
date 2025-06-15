<x-layouts.app :title="__('Crear Tipo de Negocio')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Nuevo Tipo de Negocio</h2>

        <form action="{{ route('tipos-de-negocio.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre') }}"
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
                @error('descripcion')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('tipos-de-negocio.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
