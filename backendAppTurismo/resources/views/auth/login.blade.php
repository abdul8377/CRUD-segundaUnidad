<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar sesión - {{ config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
      body {
        font-family: 'Instrument Sans', sans-serif;
      }
      input {
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
<body class="bg-gray-100 dark:bg-zinc-900 min-h-screen flex text-[16px] leading-relaxed">
  <div class="flex w-screen flex-wrap text-zinc-800 dark:text-white">
    <!-- Panel izquierdo -->
    <div class="relative hidden h-screen select-none flex-col justify-center bg-black text-center md:flex md:w-1/2">
      <div class="mx-auto py-16 px-8 text-white xl:w-[40rem]">
        <span class="rounded-full bg-white px-3 py-1 font-semibold text-black"><i class="fas fa-star text-orange-500 mr-1"></i>Bienvenido</span>
        <p class="my-6 text-3xl font-bold leading-10">Ingresa a tu cuenta para <span class="mx-auto block w-56 whitespace-nowrap rounded-lg bg-orange-500 py-2 text-white">gestionar tu negocio</span></p>
        <p class="mb-4 text-base font-light">Accede a las herramientas y funcionalidades que te ayudarán a crecer.</p>
        <a href="#" class="font-semibold tracking-wide text-orange-400 underline underline-offset-4"><i class="fas fa-arrow-right mr-1"></i>Conoce más</a>
      </div>
    </div>

    <!-- Panel derecho -->
    <div class="flex w-full flex-col md:w-1/2 bg-white dark:bg-zinc-800">
      <div class="my-auto mx-auto flex flex-col justify-center px-6 py-12 md:justify-start lg:w-[32rem]">
        <h2 class="text-center text-3xl font-bold md:text-left md:leading-tight"><i class="fas fa-right-to-bracket text-orange-500 mr-2"></i>Iniciar sesión</h2>

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 mt-4 rounded">
          {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5 pt-6">
          @csrf

          <div class="relative">
            <i class="fas fa-user absolute top-3 left-3 text-gray-400"></i>
            <input id="user" name="user" type="text" placeholder="Nombre de usuario" value="{{ old('user') }}" required class="pl-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" autocomplete="username" />
          </div>

          <div class="relative">
            <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
            <input id="password" name="password" type="password" placeholder="Contraseña" required class="pl-10 pr-10 w-full px-4 py-2 border-2 rounded focus:outline-none focus:border-orange-500 font-medium" autocomplete="current-password" />
            <i class="fas fa-eye absolute top-3 right-3 text-gray-400 cursor-pointer" onclick="togglePassword('password', this)"></i>
          </div>

          <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:underline">Olvidaste tu contraseña?</a>

          <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded transition flex items-center justify-center text-base">
            <i class="fas fa-sign-in-alt mr-2"></i>Entrar
          </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400 font-medium">
          ¿Aún no tienes cuenta? <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold"><i class="fas fa-user-plus mr-1"></i>Regístrate</a>
        </p>
      </div>
    </div>
  </div>

<script>
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
</script>
@livewireScripts
</body>
</html>
