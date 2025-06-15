<x-layouts.app :title="__('Confirmar Emprendimiento')">
    <div class="max-w-2xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Confirmar Datos del Emprendimiento</h2>

        <!-- Formulario de Confirmación -->
        <form action="{{ route('emprendimiento.storeAssignedUser') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nombre del Emprendimiento -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Emprendimiento</label>
                <input type="text" name="nombre" id="nombre" value="{{ $emprendimiento->nombre }}" disabled
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" disabled
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">{{ $emprendimiento->descripcion }}</textarea>
            </div>

            <!-- Tipo de Negocio -->
            <div>
                <label for="tipo_negocio_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Negocio</label>
                <input type="text" value="{{ $emprendimiento->tipoNegocio->nombre }}" disabled
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Información del Usuario -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Información del Usuario</h3>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usuario</label>
                <input type="text" value="{{ $user->name }}" disabled
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <hr class="my-6 border-gray-300 dark:border-neutral-700">

            <!-- Selección de Rol -->
            <div>
                <label for="rol_emprendimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol en el Emprendimiento</label>
                <select name="rol_emprendimiento" id="rol_emprendimiento"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
                    <option value="propietario">Propietario</option>
                    <option value="colaborador">Colaborador</option>
                </select>
                @error('rol_emprendimiento')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('emprendimientos.create', $user->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                    Editar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    Confirmar Emprendimiento
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
