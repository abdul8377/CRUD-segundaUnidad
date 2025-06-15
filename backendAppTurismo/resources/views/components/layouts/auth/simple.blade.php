<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
            .password-strength {
                height: 6px;
                border-radius: 4px;
            }
            input, select {
                font-size: 1rem;
            }
            h2 {
                font-weight: 700;
            }
            small, .text-sm {
                font-size: 0.875rem;
            }
        </style>
    </head>
    <body class="min-h-screen bg-gray-100 dark:bg-zinc-900 antialiased text-[16px] leading-relaxed">
        <div class="flex w-screen flex-wrap text-zinc-800 dark:text-white">
            <!-- Panel izquierdo -->
            <div class="relative hidden h-screen select-none flex-col justify-center bg-black text-center md:flex md:w-1/2">
                <div class="mx-auto py-16 px-8 text-white xl:w-[40rem]">
                    <span class="rounded-full bg-white px-3 py-1 font-semibold text-black">
                        <i class="fas fa-star text-orange-500 mr-1"></i>Nuevo
                    </span>
                    <p class="my-6 text-3xl font-bold leading-10">
                        Crea animaciones con
                        <span class="mx-auto block w-56 whitespace-nowrap rounded-lg bg-orange-500 py-2 text-white">
                            drag and drop
                        </span>
                    </p>
                    <p class="mb-4 text-base font-light">Diseña, arrastra y publica con estilo profesional.</p>
                    <a href="#" class="font-semibold tracking-wide text-orange-400 underline underline-offset-4">
                        <i class="fas fa-arrow-right mr-1"></i>Saber más
                    </a>
                </div>
            </div>

            <!-- Panel derecho con slot -->
            <div class="flex w-full flex-col md:w-1/2 bg-white dark:bg-zinc-800">
                <div class="my-auto mx-auto flex flex-col justify-center px-6 py-12 md:justify-start lg:w-[32rem]">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            const countrySelect = document.getElementById('country');
            const flagPreview = document.getElementById('flag-preview');

            function updateFlagPreview() {
                const selectedOption = countrySelect?.options[countrySelect.selectedIndex];
                const flagUrl = selectedOption?.getAttribute('data-flag');
                if (flagPreview && selectedOption) {
                    flagPreview.src = flagUrl || '';
                    flagPreview.style.display = flagUrl && selectedOption.value !== '' ? 'inline' : 'none';
                }
            }

            function togglePassword(id, icon) {
                const input = document.getElementById(id);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            function checkPasswordStrength(password) {
                const bar = document.getElementById('strength-bar');
                const text = document.getElementById('strength-text');
                let strength = 0;

                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                const colors = ['bg-red-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];
                const messages = ['Muy débil', 'Regular', 'Buena', 'Fuerte'];

                if (bar) bar.className = 'password-strength mt-2 ' + (colors[strength - 1] || '');
                if (text) text.textContent = strength ? messages[strength - 1] : '';
            }

            window.addEventListener('DOMContentLoaded', updateFlagPreview);
            if (countrySelect) countrySelect.addEventListener('change', updateFlagPreview);
        </script>

        @fluxScripts
        @livewireScripts
    </body>
</html>
