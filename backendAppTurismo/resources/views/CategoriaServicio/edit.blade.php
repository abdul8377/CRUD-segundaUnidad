<x-layouts.app :title="__('Editar Categoría de Servicio')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Editar Categoría de Servicio: {{ $categoriaDeServicio->nombre }}</h2>

        <!-- Formulario para editar la categoría de servicio -->
        <form action="{{ route('categorias-servicios.update', $categoriaDeServicio) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoriaDeServicio->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('descripcion', $categoriaDeServicio->descripcion) }}</textarea>
            </div>

            <!-- Botón para guardar cambios -->
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                Guardar Cambios
            </button>
        </form>
    </div>
</x-layouts.app>
