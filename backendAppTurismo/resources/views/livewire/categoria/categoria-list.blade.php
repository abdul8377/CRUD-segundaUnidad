<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-6">
    <div class="bg-white shadow-2xl rounded-lg p-6 overflow-hidden"> <!-- Contenedor raíz único para Livewire -->
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Lista de Categorías</h2>

        <!-- Si hay categorías, mostrarlas en una tabla -->
        @if($categorias->count() > 0)
            <table class="min-w-full table-auto border-collapse text-sm text-gray-600">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">ID</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Nombre</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Tipo</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Descripción</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-6 border-b text-gray-800">{{ $categoria->id }}</td>
                            <td class="py-3 px-6 border-b text-gray-800">{{ $categoria->nombre }}</td>
                            <td class="py-3 px-6 border-b text-gray-800">{{ $categoria->tipo }}</td>
                            <td class="py-3 px-6 border-b text-gray-800">{{ $categoria->descripcion }}</td>
                            <td class="py-3 px-6 border-b text-gray-800">
                                <!-- Agregar botones de acción con iconos -->
                                <button class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No hay categorías disponibles.</p>
        @endif
    </div>
</div>
