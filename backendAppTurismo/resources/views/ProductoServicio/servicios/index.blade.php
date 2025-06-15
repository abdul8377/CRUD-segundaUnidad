<x-layouts.app :title="'Mis Servicios'">
    <div class="max-w-7xl mx-auto p-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                <i class="fas fa-box text-orange-500 mr-2"></i>Servicios registrados
            </h2>
            <a href="{{ route('servicios.create') }}"
               class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded hover:bg-orange-600">
                <i class="fas fa-plus mr-1"></i>Nuevo servicio
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($servicios->isEmpty())
            <div class="text-gray-600 dark:text-gray-300">Aún no has registrado servicios.</div>
        @else
            <div class="overflow-x-auto bg-white dark:bg-neutral-900 rounded shadow">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Precio</th>
                            <th class="px-4 py-3">Capacidad</th>
                            <th class="px-4 py-3">Duración</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach ($servicios as $servicio)
                            <tr>
                                <td class="px-4 py-2">{{ $servicio->nombre }}</td>
                                <td class="px-4 py-2">S/ {{ number_format($servicio->precio, 2) }}</td>
                                <td class="px-4 py-2">{{ $servicio->capacidad_maxima }}</td>
                                <td class="px-4 py-2">{{ $servicio->duracion_servicio ? $servicio->duracion_servicio . ' min' : '-' }}</td>
                                <td class="px-4 py-2">{{ $servicio->categoria->nombre ?? 'Sin categoría' }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('servicios.edit', $servicio->servicios_id) }}" class="text-blue-600 hover:underline text-sm mr-2">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('servicios.destroy', $servicio->servicios_id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este servicio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
