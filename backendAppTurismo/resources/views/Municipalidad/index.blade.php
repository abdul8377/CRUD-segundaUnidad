<x-layouts.app :title="__('Municipalidad')">
    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- COLUMNA IZQUIERDA --}}
        <div class="space-y-6">
            {{-- DATOS MUNICIPALIDAD --}}
            <div class="bg-white dark:bg-neutral-900 p-6 rounded shadow">
                <h2 class="text-xl font-bold flex items-center gap-2 mb-4 text-blue-600">
                    <i class="fas fa-landmark"></i> Municipalidad
                </h2>

                @foreach(['direccion','descripcion','ruc','correo','telefono','nombre_alcalde','facebook_url','anio_gestion'] as $campo)
                    <div class="mb-3">
                        <label class="block font-semibold capitalize text-gray-600 dark:text-gray-300">
                            {{ str_replace('_', ' ', $campo) }}
                        </label>
                        <div class="flex justify-between items-center">
                            <span id="span-{{ $campo }}" class="text-gray-800 dark:text-white">
                                {{ $municipalidad->$campo ?? 'No registrado' }}
                            </span>
                            <button onclick="editarCampo('{{ $campo }}')" class="text-xs flex items-center gap-1 border border-gray-300 px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-neutral-800">
                                <i class="fas fa-pen"></i> Editar
                            </button>
                        </div>
                        <form id="form-{{ $campo }}" action="{{ route('municipalidad.update', $municipalidad->municipalidad_descripcion_id) }}" method="POST" class="hidden mt-2">
                            @csrf @method('PUT')
                            <div class="flex gap-2">
                                <input type="text" name="{{ $campo }}" class="w-full rounded border-gray-300 px-3 py-1 dark:bg-neutral-800 dark:text-white" value="{{ $municipalidad->$campo }}">
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- CONFIGURACIÓN APP --}}
            <div class="bg-white dark:bg-neutral-900 border-l-4 border-yellow-400 p-6 rounded-lg shadow space-y-4">
                <h3 class="text-lg font-semibold text-yellow-600 flex items-center gap-2">
                    <i class="fas fa-cogs"></i> Configuración App Móvil
                </h3>

                <form action="{{ route('municipalidad.update', $municipalidad->municipalidad_descripcion_id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="nombre" value="{{ $municipalidad->nombre }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-900 dark:text-white dark:bg-neutral-800 focus:ring-2 focus:ring-yellow-400">
                            <button type="submit" title="Guardar" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Color Primario --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color Primario</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="color_primario" value="{{ $municipalidad->color_primario ?? '#1D4ED8' }}" class="w-12 h-10 rounded-lg border shadow">
                            <button type="submit" title="Guardar" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Color Secundario --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color Secundario</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="color_secundario" value="{{ $municipalidad->color_secundario ?? '#111827' }}" class="w-12 h-10 rounded-lg border shadow">
                            <button type="submit" title="Guardar" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Mantenimiento --}}
                <div class="pt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mantenimiento</label>
                    <form action="{{ route('municipalidad.toggleMantenimiento', $municipalidad->municipalidad_descripcion_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-sm transition-colors duration-200 {{ $municipalidad->mantenimiento ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white">
                            <i class="fas {{ $municipalidad->mantenimiento ? 'fa-times' : 'fa-check' }} mr-2"></i>
                            {{ $municipalidad->mantenimiento ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </div>

                {{-- Logo --}}
                @php
                    $logo = $municipalidad->images->where('tipo', 'logo')->sortByDesc('created_at')->first();
                @endphp
                <div class="pt-6">
                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-2">Logo</label>
                    <div class="relative w-32 h-32 rounded overflow-hidden border bg-white dark:bg-neutral-800 shadow">
                        <img src="{{ $logo ? asset('storage/' . $logo->url) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                        <form action="{{ route('municipalidad.imagen', $municipalidad->municipalidad_descripcion_id) }}" method="POST" enctype="multipart/form-data" class="absolute bottom-2 right-2 z-10">
                            @csrf
                            <input type="hidden" name="tipo" value="logo">
                            <label class="cursor-pointer">
                                <div class="w-8 h-8 bg-black bg-opacity-70 rounded-full flex items-center justify-center hover:bg-opacity-90 transition">
                                    <i class="fas fa-camera text-white text-xs"></i>
                                </div>
                                <input type="file" name="image" class="hidden" onchange="this.form.submit()">
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: Portada + Perfil + Galería --}}
        <div class="space-y-6">
            @php
                $portada = $municipalidad->images->where('tipo', 'portada')->sortByDesc('created_at')->first();
                $perfil = $municipalidad->images->where('tipo', 'perfil')->sortByDesc('created_at')->first();
            @endphp

            {{-- Portada y perfil --}}
            <div class="relative bg-white dark:bg-neutral-900 rounded-lg shadow overflow-hidden">
                <div class="relative h-60 md:h-72 w-full bg-gray-200 overflow-hidden">
                    <img src="{{ $portada ? asset('storage/' . $portada->url) : 'https://via.placeholder.com/1200x300' }}" class="w-full h-full object-cover">
                    <form action="{{ route('municipalidad.imagen', $municipalidad->municipalidad_descripcion_id) }}" method="POST" enctype="multipart/form-data" class="absolute top-4 right-4 z-30">
                        @csrf
                        <input type="hidden" name="tipo" value="portada">
                        <label class="cursor-pointer">
                            <div class="w-10 h-10 bg-black bg-opacity-70 hover:bg-opacity-90 rounded-full flex items-center justify-center shadow-lg transition">
                                <i class="fas fa-camera text-white text-sm"></i>
                            </div>
                            <input type="file" name="image" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <div class="relative z-20 flex justify-center -mt-16">
                    <div class="w-32 h-32 rounded-full border-4 border-white bg-white shadow relative">
                        <img src="{{ $perfil ? asset('storage/' . $perfil->url) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    <form action="{{ route('municipalidad.imagen', $municipalidad->municipalidad_descripcion_id) }}" method="POST" enctype="multipart/form-data" class="absolute right-[calc(50%-4rem)] bottom-[-12px] z-40">
                        @csrf
                        <input type="hidden" name="tipo" value="perfil">
                        <label class="cursor-pointer">
                            <div class="w-10 h-10 bg-black bg-opacity-80 rounded-full flex items-center justify-center shadow-xl hover:bg-opacity-100 transition">
                                <i class="fas fa-camera text-white text-sm"></i>
                            </div>
                            <input type="file" name="image" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <div class="text-center mt-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $municipalidad->nombre ?? 'Nombre de la Municipalidad' }}</h2>
                    <p class="text-gray-500 text-sm">{{ $municipalidad->descripcion ?? 'Descripción corta de la municipalidad' }}</p>
                </div>
            </div>

            {{-- GALERÍA --}}
            <div class="pt-14">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <i class="fas fa-photo-film"></i> Mis imágenes
                    </h3>
                    <a href="{{ route('municipalidad.galeria') }}" class="text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 flex items-center gap-1">
                        <i class="fas fa-eye"></i> Ver todos
                    </a>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($municipalidad->images->sortByDesc('created_at')->take(3) as $imagen)
                        <img src="{{ asset('storage/' . $imagen->url) }}" class="w-full h-24 object-cover rounded shadow border hover:scale-105 transition-transform duration-200">
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function editarCampo(campo) {
            document.getElementById('span-' + campo).style.display = 'none';
            document.getElementById('form-' + campo).classList.remove('hidden');
        }
    </script>
</x-layouts.app>
