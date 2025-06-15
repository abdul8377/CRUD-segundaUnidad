<x-layouts.app :title="__('Categorías de Servicio')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Categorías de Servicio</h2>

        <!-- Botón Crear -->
        <a href="{{ route('categorias-servicios.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 mb-4">
            Crear Nueva Categoría
        </a>

        <!-- Tabla -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Servicios Vinculados</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Opciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                @foreach($categorias as $categoria)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $categoria->categorias_servicios_id  }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $categoria->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $categoria->descripcion }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $categoria->servicios_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            <a href="{{ route('categorias-servicios.show', $categoria) }}" class="text-blue-600 hover:text-blue-800">Ver Servicios</a>
                            <a href="{{ route('categorias-servicios.edit', $categoria) }}" class="ml-4 text-yellow-400 hover:text-yellow-600">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
