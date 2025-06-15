<x-layouts.app :title="__('Detalles del Turista')">
    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-neutral-900 p-6 rounded-lg shadow">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Detalles del Turista: {{ $turista->name }}</h2>

        <!-- Detalles del Usuario -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Información del Usuario</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Email:</strong> {{ $turista->email }}</p>
        </div>

        <!-- Detalles del Perfil de Turista -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Perfil del Turista</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Nacionalidad:</strong> {{ $turista->perfilTurista->nacionalidad }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Edad:</strong> {{ $turista->perfilTurista->edad ?? 'No disponible' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Intereses:</strong> {{ $turista->perfilTurista->intereses ?? 'No disponible' }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('turistas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-white text-sm font-medium rounded-md hover:bg-gray-300">
                Volver a la lista de turistas
            </a>
        </div>
    </div>
</x-layouts.app>
