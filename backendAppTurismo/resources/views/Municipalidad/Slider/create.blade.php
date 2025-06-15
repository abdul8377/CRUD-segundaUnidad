<x-layouts.app :title="'Crear nuevo slider'">
    <div class="max-w-2xl mx-auto p-6 bg-white dark:bg-neutral-900 rounded shadow">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">
            <i class="fas fa-plus-circle text-orange-500 mr-2"></i>Crear nuevo slider
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Imagen -->
            <div>
                <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Imagen destacada <span class="text-red-500">*</span>
                </label>
                <input type="file" name="imagen" id="imagen" accept="image/*"
                       class="mt-1 block w-full text-sm border-gray-300 rounded focus:outline-none focus:ring-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
                <small class="text-gray-500">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 5 MB</small>
            </div>

            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                       class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">{{ old('descripcion') }}</textarea>
            </div>

            <!-- Orden -->
            <div>
                <label for="orden" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orden</label>
                <input type="number" name="orden" id="orden" value="{{ old('orden') }}"
                       class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('slider.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded hover:bg-gray-300 dark:hover:bg-neutral-600">
                    ← Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded hover:bg-orange-600">
                    <i class="fas fa-upload mr-1"></i>Guardar Slider
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
