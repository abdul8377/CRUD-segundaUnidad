<x-layouts.app :title="__('Tipos de Negocio')">
    <div class="flex flex-col gap-6">

        <!-- Título + Botón Crear -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Tipos de Negocio</h1>
            <a href="{{ route('tipos-de-negocio.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                Crear nuevo
            </a>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"># Emprendimientos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Opciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($tipos as $tipo)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $tipo->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $tipo->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $tipo->descripcion }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-800 dark:text-gray-200">{{ $tipo->emprendimientos_count }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('tipos-de-negocio.edit', $tipo) }}"
                                   class="inline-block px-3 py-1 bg-yellow-400 text-white text-xs rounded hover:bg-yellow-500">
                                    Editar
                                </a>
                                <a href="{{ route('tipos-de-negocio.show', $tipo) }}"
                                   class="inline-block px-3 py-1 bg-indigo-500 text-white text-xs rounded hover:bg-indigo-600">
                                    Inspeccionar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
