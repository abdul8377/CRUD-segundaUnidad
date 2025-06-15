<x-layouts.app :title="'Cambiar slider orden ' . $orden">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <h1 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">
            Sliders disponibles para orden {{ $orden }}
        </h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($slidersDisponibles->isEmpty())
            <div class="text-gray-600 dark:text-gray-300">No hay sliders disponibles para este orden.</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($slidersDisponibles as $slider)
                    <div class="border rounded-lg overflow-hidden bg-white dark:bg-neutral-900 shadow">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset($slider->portada->url ?? 'https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg') }}"
                                 alt="Slider" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h2 class="font-bold text-lg text-gray-800 dark:text-white">{{ $slider->titulo ?? 'Sin título' }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $slider->descripcion }}</p>
                            <p class="text-xs text-gray-400 mt-1">Orden: {{ $slider->orden }}</p>

                            <div class="flex justify-end mt-4 space-x-2">
                                <form action="{{ route('slider.activar', $slider->slider_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Usar este
                                    </button>
                                </form>
                                <a href="{{ route('slider.edit', $slider->slider_id) }}"
                                   class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
