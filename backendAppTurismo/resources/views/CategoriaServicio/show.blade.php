<x-layouts.app :title="__('Detalles de Categoría de Servicio')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Detalles de Categoría: {{ $categoria->nombre }}</h2>

        <!-- Información de la Categoría -->

        <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
        <p><strong>Descripción:</strong> {{ $categoria->descripcion ?? 'No hay descripción disponible.' }}</p>

        <h3 class="mt-6 text-lg font-semibold text-gray-800 dark:text-white">Servicios Vinculados</h3>

        <!-- Tabla de Servicios -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre del Servicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Emprendimiento</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                @foreach($categoria->servicios as $servicio)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $servicio->servicios_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $servicio->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $servicio->precio }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ $servicio->emprendimiento->nombre }} <!-- Mostrar nombre del emprendimiento -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
