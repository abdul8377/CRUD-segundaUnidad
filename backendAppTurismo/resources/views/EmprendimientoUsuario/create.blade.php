<x-layouts.app :title="__('Crear Emprendimiento y Asignar Usuario')">
    <div class="max-w-6xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Crear Emprendimiento y Asignar Usuario</h2>

        <!-- Formulario para crear el emprendimiento y asignar un usuario y rol -->
        <form action="{{ route('emprendimiento-usuarios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="usuario_id" value="{{ $emprendedor->id }}">

            <div class="grid grid-cols-1 gap-6 mb-4">

                <!-- Tipo de Negocio -->
                <div>
                    <label for="tipo_negocio_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Negocio</label>
                                    <select name="tipo_negocio_id" id="tipo_negocio_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Selecciona un tipo de negocio</option>
                    @foreach($tiposDeNegocio as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
                    @error('tipo_negocio_id')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nombre del Emprendimiento -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Emprendimiento</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Descripción del Emprendimiento -->
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>

                <!-- Dirección -->
                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <!-- Imagen destacada -->
                <div>
                    <label for="imagen_destacada" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen Destacada</label>
                    <input type="file" name="imagen_destacada" id="imagen_destacada" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <!-- Selección del Rol -->
                <div>
                    <label for="rol_emprendimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol en el Emprendimiento</label>
                    <select name="rol_emprendimiento" id="rol_emprendimiento" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="propietario">Propietario</option>
                        <option value="colaborador">Colaborador</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('emprendedores.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Crear y Asignar Rol</button>
            </div>
        </form>
    </div>
</x-layouts.app>
