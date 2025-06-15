<x-layouts.app :title="__('Detalles de la Categoría de Producto')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Detalles de la Categoría: {{ $categoria->nombre }}</h2>

        <!-- Información de la Categoría -->
        <div class="mb-4">
            <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>
        </div>

        <!-- Productos Asociados -->
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Productos Asociados</h3>
        @if($categoria->productos->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No hay productos asociados a esta categoría.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($categoria->productos as $producto)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $producto->productos_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $producto->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">${{ $producto->precio }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $producto->stock }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                <a href="{{ route('productos.show', $producto->productos_id) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                                <a href="{{ route('productos.edit', $producto->productos_id) }}" class="ml-4 text-yellow-400 hover:text-yellow-600">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Enlace para volver a la lista -->
        <a href="{{ route('categorias-productos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 mt-6">
            Volver a la Lista de Categorías
        </a>
    </div>
</x-layouts.app>
