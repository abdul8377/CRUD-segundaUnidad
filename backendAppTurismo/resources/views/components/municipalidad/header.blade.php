@php
    $logo = null;
    $colorPrimario = '#1D4ED8'; // Azul por defecto
    $colorSecundario = '#6B7280'; // Gris por defecto
    $nombre = 'Nombre no registrado';
    $correo = 'correo@no-disponible.com';

    if ($municipalidad) {
        $logo = $municipalidad->images?->where('tipo', 'logo')->sortByDesc('created_at')->first();
        $colorPrimario = $municipalidad->color_primario ?: $colorPrimario;
        $colorSecundario = $municipalidad->color_secundario ?: $colorSecundario;
        $nombre = $municipalidad->nombre ?? $nombre;
        $correo = $municipalidad->correo ?? $correo;
    }
@endphp


<div class="flex items-center gap-3 w-full max-w-full">
    <!-- LOGO -->
    <div class="flex aspect-square w-10 h-10 min-w-[2.5rem] items-center justify-center rounded-md overflow-hidden border shadow">
        @if ($logo)
            <img src="{{ asset('storage/' . $logo->url) }}"
                 alt="Logo"
                 class="w-full h-full object-cover" />
        @else
            <x-app-logo-icon class="w-6 h-6 fill-current text-white dark:text-black" />
        @endif
    </div>

    <!-- INFORMACIÓN -->
    <div class="flex-1 min-w-0">
        <span class="block text-sm font-bold leading-tight break-words whitespace-normal"
              style="color: {{ $colorPrimario }};">
            {{ $nombre }}
        </span>
        <span class="block text-xs leading-tight break-all"
              style="color: {{ $colorSecundario }};">
            {{ $correo }}
        </span>
    </div>
</div>
