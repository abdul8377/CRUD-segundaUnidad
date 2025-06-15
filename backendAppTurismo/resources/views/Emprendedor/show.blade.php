<x-layouts.app :title="__('Detalles del Emprendedor')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-lg">

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 flex items-center space-x-2">
            <i class="fas fa-user-circle text-blue-600"></i>
            <span>Detalles de: {{ $emprendedor->name }}</span>
        </h2>

        <!-- Información del Usuario -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Información del Usuario</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Email:</strong> {{ $emprendedor->email }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Rol:</strong> {{ $emprendedor->getRoleNames()->first() }}</p>
        </div>

        <!-- Emprendimientos Vinculados -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Emprendimientos Vinculados</h3>
            @foreach($emprendedor->emprendimientos as $emprendimiento)
                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-white">{{ $emprendimiento->nombre }}</h4>

                    <!-- Imagen del Emprendimiento -->
                    <div class="w-1/3 p-4 border-2 border-gray-300 rounded-md shadow-sm">
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Imagen del Emprendimiento</h5>
                        <!-- Mostrar la URL completa de la imagen si está disponible -->
                        <img src="{{ $emprendimiento->image ? asset('storage/' . $emprendimiento->image->url) : 'https://via.placeholder.com/150' }}"
                            alt="Imagen de Emprendimiento" class="w-full h-auto object-cover rounded-md">
                    </div>



                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>URL:</strong> {{ $emprendimiento->image ? $emprendimiento->image->url : 'No image available' }}</p>

                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Descripción:</strong> {{ $emprendimiento->descripcion }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Estado:</strong> {{ $emprendimiento->estado }}</p>
                </div>
            @endforeach
        </div>

        <!-- Botón de Volver -->
        <div class="mt-6">
            <a href="{{ route('emprendedores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                Volver a la lista de emprendedores
            </a>
        </div>
    </div>
</x-layouts.app>
