<x-layouts.app :title="__('Lista de Emprendedores')">
    <div class="max-w-6xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-lg">

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center space-x-2">
            <i class="fas fa-users text-blue-600"></i>
            <span>Emprendedores</span>
        </h2>

        <!-- Botón de Crear Nuevo Emprendedor -->
        <a href="{{ route('emprendedores.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 mb-4">
            <i class="fas fa-plus mr-2"></i>Crear Nuevo Emprendedor
        </a>

        <!-- Tabla de Emprendedores -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Correo de Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Emprendimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Opciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($emprendedores as $emprendedor)
                        <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendedor->perfilEmprendedor->perfil_emprendedor_id ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendedor->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendedor->perfilEmprendedor->telefono_contacto ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $emprendedor->perfilEmprendedor->gmail_contacto ?? 'N/A' }}</td>

                            <!-- Columna de Emprendimiento con lógica para mostrar el estado o el botón -->
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 space-x-2">
                                @if ($emprendedor->emprendimientoUsuarios->isEmpty())  <!-- Si el emprendedor no tiene emprendimiento vinculado -->
                                    <span class="text-yellow-500">No Vinculado</span>
                                    <a href="{{ route('emprendimiento-usuarios.create', $emprendedor->id) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 mt-2">
                                        <i class="fas fa-plus-circle mr-2"></i>Asignar Emprendimiento
                                    </a>
                                @else
                                    <span class="text-green-500">Vinculado</span>
                                @endif
                            </td>

                            <!-- Columna de Opciones -->
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 space-x-2">
                                <!-- Ver Detalles -->
                                <a href="{{ route('emprendedores.show', $emprendedor) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    <i class="fas fa-eye mr-2"></i>Ver
                                </a>

                                <!-- Cambiar Contraseña -->
                                <a href="{{ route('emprendedores.edit', $emprendedor) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-key mr-2"></i>Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
