<x-layouts.app :title="__('Crear Nueva Categoría de Producto')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Crear Nueva Categoría de Producto</h2>

        <!-- Mostrar mensajes de éxito o error -->
        @if(session('success'))
            <div class="alert alert-success bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger bg-red-500 text-white p-3 rounded-md mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario de Creación -->
        <form action="{{ route('categorias-productos.store') }}" method="POST">
            @csrf

            <!-- Nombre de la categoría -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
            </div>

            <!-- Descripción de la categoría -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"></textarea>
            </div>

            <!-- Botón para crear la categoría -->
            <button type="submit" class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Crear Categoría
            </button>
        </form>

        <!-- Enlace para volver a la lista -->
        <a href="{{ route('categorias-productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 mt-6">
            Volver a la Lista de Categorías
        </a>
    </div>
</x-layouts.app>
