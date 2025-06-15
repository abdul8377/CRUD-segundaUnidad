<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>

        <div class="flex items-center justify-center min-h-screen">
            <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-xs w-full">
                <h1 class="text-3xl font-semibold text-blue-600 mb-4">¡Tailwind CSS está funcionando!</h1>
                <p class="text-gray-700">Si ves este mensaje con el estilo adecuado, Tailwind CSS está correctamente instalado.</p>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Botón de prueba</button>
            </div>
        </div>
    </div>



</x-layouts.app>
