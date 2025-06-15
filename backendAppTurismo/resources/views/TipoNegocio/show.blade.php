<x-layouts.app :title="__('Ver Tipo de Negocio')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <!-- Título del tipo de negocio -->
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
            {{ $tipoDeNegocio->nombre }}
        </h2>

        <!-- Descripción del tipo de negocio -->
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
            {{ $tipoDeNegocio->descripcion ?? 'No hay descripción disponible.' }}
        </p>

        <!-- Tabla de emprendimientos vinculados -->
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Emprendimientos Vinculados</h3>

        @if($tipoDeNegocio->emprendimientos->isEmpty())
            <p class="text-gray-500">No hay emprendimientos vinculados a este tipo de negocio.</p>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach($tipoDeNegocio->emprendimientos as $emprendimiento)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendimiento->emprendimientos_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendimiento->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendimiento->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Botón de regreso -->
        <div class="mt-6">
            <a href="{{ route('tipos-de-negocio.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                Volver a la lista de tipos de negocio
            </a>
        </div>
    </div>
</x-layouts.app>
