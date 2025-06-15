<x-layouts.app :title="__('Lista de Turistas')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Turistas</h2>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                @foreach($turistas as $turista)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $turista->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $turista->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            <a href="{{ route('turistas.show', $turista) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalles</a>
                            <a href="{{ route('turistas.edit', $turista) }}" class="ml-4 text-yellow-400 hover:text-yellow-600">Editar Contraseña</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
