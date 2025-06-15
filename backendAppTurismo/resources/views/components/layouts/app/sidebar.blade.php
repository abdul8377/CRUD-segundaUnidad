@php
    $groups = [
        'APP' => array_filter([
            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Municipalidad',
                'icon' => 'tag',
                'url' => route('municipalidad.index'),
                'current' => request()->routeIs('municipalidad.*'),
                'can' => true
            ] : null,
             auth()->user()->hasRole('Administrador') ? [
                'name' => 'Slider',
                'icon' => 'photo',
                'url' => route('slider.index'),
                'current' => request()->routeIs('slider.*'),
                'can' => true
            ] : null,
        ]),

        'Platform' => array_filter([
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'url' => route('dashboard'),
                'current' => request()->routeIs('dashboard')
            ],

            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Tipos de Negocio',
                'icon' => 'briefcase',
                'url' => route('tipos-de-negocio.index'),
                'current' => request()->routeIs('tipos-de-negocio.*'),
                'can' => true
            ] : null,

            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Emprendedores',
                'icon' => 'user-group',
                'url' => route('emprendedores.index'),
                'current' => request()->routeIs('emprendedores.*'),
                'can' => true
            ] : null,

            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Turistas',
                'icon' => 'users',
                'url' => route('turistas.index'),
                'current' => request()->routeIs('turistas.*'),
                'can' => true
            ] : null,
        ]),

        'Categorias' => array_filter([
            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Categorías de Servicio',
                'icon' => 'tag',
                'url' => route('categorias-servicios.index'),
                'current' => request()->routeIs('categorias-servicios.*'),
                'can' => true
            ] : null,

            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Categorías de Producto', // Aquí se cambió de 'Categorías de Servicio' a 'Categorías de Producto'
                'icon' => 'archive-box', // Cambié el icono por uno de Flux Heroic Icons
                'url' => route('categorias-productos.index'), // Ruta actualizada para Categorías de Producto
                'current' => request()->routeIs('categorias-productos.*'), // Actualización de la ruta para Categorías de Producto
                'can' => true
            ] : null,

            auth()->user()->hasRole('Administrador') ? [
                'name' => 'Tipos de Negocio',
                'icon' => 'briefcase',
                'url' => route('tipos-de-negocio.index'),
                'current' => request()->routeIs('tipos-de-negocio.*'),
                'can' => true
            ] : null,
        ]),

        'Productos Servicios' => array_filter([
            auth()->check() && auth()->user()->hasRole('Emprendedor') ? [
                'name' => 'servicios',
                'icon' => 'tag',
                'url' => route('servicios.index'),
                'current' => request()->routeIs('servicios.*'),
                'can' => true
            ] : null,
        ]),
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-municipalidad.header :municipalidad="$municipalidad" />
            </a>
            @php
                $rol = auth()->user()->getRoleNames()->first() ?? 'Sin Rol';
            @endphp

            @if($rol !== 'Usuario')
                <div class="text-xl font-semibold text-gray-800 dark:text-white">
                    Panel de <span class="text-primary-600">{{ ucfirst($rol) }}</span>
                </div>
            @endif



            <flux:navlist variant="outline">
                @foreach ($groups as $group => $links)
                    @php
                        $visibleLinks = collect($links)->filter(function ($link) {
                            return !isset($link['can']) || $link['can'];
                        });
                    @endphp

                    @if ($visibleLinks->isNotEmpty())
                        <flux:navlist.group :heading="$group" class="grid">
                            @foreach ($visibleLinks as $link)
                                <flux:navlist.item
                                    :icon="$link['icon']"
                                    :href="$link['url']"
                                    :current="$link['current']"
                                    wire:navigate>
                                    {{ $link['name'] }}
                                </flux:navlist.item>
                            @endforeach
                        </flux:navlist.group>
                    @endif
                @endforeach

            </flux:navlist>


            <flux:spacer />

            {{-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> --}}

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts

        @if (session('swal'))

            <script>
                Swal.fire(@json(session('swal')));
            </script>

        @endif
    </body>
</html>
