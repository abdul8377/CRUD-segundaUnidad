<x-layouts.app :title="'Registrar Servicio'">
    <div class="max-w-3xl mx-auto p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">
            <i class="fas fa-plus text-orange-500 mr-2"></i>Nuevo Servicio
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('servicios.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="block font-medium text-gray-700 dark:text-gray-300">Nombre del servicio</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                       class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
            </div>

            <div>
                <label for="descripcion" class="block font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                          class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label for="precio" class="block font-medium text-gray-700 dark:text-gray-300">Precio (S/)</label>
                <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio') }}"
                       class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
            </div>

            <div>
                <label for="capacidad_maxima" class="block font-medium text-gray-700 dark:text-gray-300">Capacidad máxima</label>
                <input type="number" id="capacidad_maxima" name="capacidad_maxima" value="{{ old('capacidad_maxima') }}"
                       class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white" required>
            </div>

            <div>
                <label for="duracion_servicio" class="block font-medium text-gray-700 dark:text-gray-300">Duración (minutos)</label>
                <input type="number" id="duracion_servicio" name="duracion_servicio" value="{{ old('duracion_servicio') }}"
                       class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <div>
                <label for="imagen_destacada" class="block font-medium text-gray-700 dark:text-gray-300">URL de imagen destacada (opcional)</label>
                <input type="text" id="imagen_destacada" name="imagen_destacada" value="{{ old('imagen_destacada') }}"
                       class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <div>
                <label for="categorias_servicios_id" class="block font-medium text-gray-700 dark:text-gray-300">Categoría del servicio</label>
                <select id="categorias_servicios_id" name="categorias_servicios_id" required
                        class="w-full mt-1 px-4 py-2 border-2 rounded focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->categorias_servicios_id }}" {{ old('categorias_servicios_id') == $categoria->categorias_servicios_id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('servicios.index') }}"
                   class="px-4 py-2 bg-gray-300 dark:bg-neutral-700 text-gray-800 dark:text-white rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Registrar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
