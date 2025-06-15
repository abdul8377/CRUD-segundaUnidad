<x-layouts.app :title="__('Galería de Imágenes')">
    <div class="max-w-7xl mx-auto mt-8 p-6 bg-white dark:bg-neutral-900 rounded-lg shadow-lg">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Galería de Imágenes</h2>
            <a href="{{ route('municipalidad.index') }}"
               class="text-blue-600 hover:underline text-sm flex items-center space-x-1">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-300 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($municipalidad && $municipalidad->images->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($municipalidad->images->sortByDesc('created_at') as $image)
                    <div class="relative group border rounded-lg overflow-hidden shadow hover:shadow-xl transition-shadow">
                        <img src="{{ asset('storage/' . $image->url) }}" alt="Imagen"
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">

                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-sm px-3 py-2 flex justify-between items-center">
                            <span class="truncate">{{ ucfirst($image->tipo ?? 'Sin tipo') }}</span>

                            <form action="{{ route('municipalidad.imagen.destroy', $image->id) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta imagen?')" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Eliminar" class="text-red-400 hover:text-red-200">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-600 dark:text-gray-300 mt-12">
                <i class="fas fa-images text-4xl mb-3 text-gray-400"></i>
                <p class="text-lg">No hay imágenes subidas aún.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
