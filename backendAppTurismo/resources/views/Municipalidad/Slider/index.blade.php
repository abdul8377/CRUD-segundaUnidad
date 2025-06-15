<x-layouts.app :title="'Sliders'">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sliders</h1>
            <a href="{{ route('slider.create') }}" class="border border-orange-600 text-orange-600 px-4 py-2 font-bold rounded hover:bg-orange-600 hover:text-white">
                nuevo sliders
            </a>
        </div>

        <!-- Sliders activos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-10">
            @foreach ([1, 2, 3] as $orden)
                @php $slider = $slidersEnOrden[$orden] ?? null; @endphp
                <div class="border rounded-xl overflow-hidden relative shadow-sm">
                    <div class="bg-red-600 text-white text-center py-2 font-bold">orden {{ $orden }}</div>
                    <div class="w-full h-48 overflow-hidden bg-gray-100 dark:bg-neutral-800 flex items-center justify-center">
                        @if ($slider && $slider->portada)
                            <img src="{{ asset('storage/' . $slider->portada->url) }}" class="w-full h-full object-cover" alt="Slider {{ $orden }}">
                        @else
                            <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg" class="w-full h-full object-cover" alt="Sin imagen">
                        @endif
                    </div>
                    <div class="absolute bottom-2 right-2">
                        <a href="{{ route('slider.editarOrden', $orden) }}" class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow hover:scale-105 transition">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
