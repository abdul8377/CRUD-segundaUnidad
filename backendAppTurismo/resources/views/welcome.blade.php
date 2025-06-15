<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capachica Travel</title>
    <!-- Link a Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link a Font Awesome 6.5.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Link a Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        /* Añadir estilos adicionales para la transición del menú */
        .menu-mobile {
            transition: transform 0.3s ease-in-out;
        }

        .menu-mobile.hidden {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Header Section -->
    <header class="flex justify-between items-center bg-gray-800 fixed top-0 left-0 w-full p-4 z-10" x-data="{ open: false }">

        <div class="lg:hidden">
            <!-- Icono Sandwich para dispositivos móviles -->
            <button @click="open = !open" class="text-white text-3xl">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <nav class="hidden lg:flex space-x-6 text-white text-sm sm:text-base md:text-lg">
            <ul class="flex space-x-6">
                <li><a href="#" class="text-decoration-none">Inicio</a></li>
                <li><a href="#" class="text-decoration-none">Acerca de</a></li>
                <li><a href="#" class="text-decoration-none">Actividades</a></li>
                <li><a href="#" class="text-decoration-none">Contacto</a></li>
                <li><a href="#" class="text-decoration-none">¿Cómo llegar?</a></li>
            </ul>
        </nav>
        <div class="login">
            <!-- Show Login Button or Dashboard Link based on user authentication -->
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-yellow-400 text-black py-2 px-4 rounded-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="bg-yellow-400 text-black py-2 px-4 rounded-md">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black py-2 px-4 rounded-md ml-4">Registrar</a>
                @endif
            @endauth
        </div>
    </header>

    <!-- Add Space for large screens if login route exists -->
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <!-- Mobile Menu (hidden by default) -->
    <nav :class="{'hidden': !open}" class="menu-mobile hidden bg-gray-800 text-white absolute top-0 left-0 w-full h-full bg-opacity-75 z-20 pt-16">
        <ul class="flex flex-col items-center space-y-4">
            <li><a href="#" class="text-decoration-none">Inicio</a></li>
            <li><a href="#" class="text-decoration-none">Acerca de</a></li>
            <li><a href="#" class="text-decoration-none">Actividades</a></li>
            <li><a href="#" class="text-decoration-none">Contacto</a></li>
            <li><a href="#" class="text-decoration-none">¿Cómo llegar?</a></li>
        </ul>
    </nav>

    <!-- Slider Section -->
    <section class="slider relative w-full h-screen">
        <!-- Main Image -->
        <div class="main-image-container relative flex justify-center items-center w-full h-full bg-gradient-to-b from-black to-transparent">
            <img id="main-image" src="https://images.trvl-media.com/lodging/58000000/57250000/57240700/57240698/eee667c4.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill" alt="Capachica Vista Principal" class="w-full h-full object-cover transition-opacity duration-1000 ease-in-out">
        </div>

        <!-- Image Thumbnails -->
        <div class="image-thumbnails absolute bottom-10 w-full flex justify-center gap-6 px-5 z-10">
            <div class="image-thumb cursor-pointer hover:scale-105 transition-transform" onclick="changeImage('https://images.alphacoders.com/131/1311351.jpeg')">
                <img src="https://images.alphacoders.com/131/1311351.jpeg" alt="Capachica Vista 2" class="w-32 h-32 object-cover rounded-xl shadow-lg">
            </div>
            <div class="image-thumb cursor-pointer hover:scale-105 transition-transform" onclick="changeImage('https://images5.alphacoders.com/361/thumb-1920-361088.jpg')">
                <img src="https://images5.alphacoders.com/361/thumb-1920-361088.jpg" alt="Capachica Vista 3" class="w-32 h-32 object-cover rounded-xl shadow-lg">
            </div>
            <div class="image-thumb cursor-pointer hover:scale-105 transition-transform" onclick="changeImage('https://cdn.tourradar.com/s3/serp/1500x800/215920_qnelkEda.jpg')">
                <img src="https://cdn.tourradar.com/s3/serp/1500x800/215920_qnelkEda.jpg" alt="Capachica Vista 4" class="w-32 h-32 object-cover rounded-xl shadow-lg">
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white text-center py-3 fixed bottom-0 w-full">
        <div class="social">
            <a href="#" class="text-white text-decoration-none mx-3"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="#" class="text-white text-decoration-none mx-3"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#" class="text-white text-decoration-none mx-3"><i class="fab fa-youtube"></i> YouTube</a>
            <a href="#" class="text-white text-decoration-none mx-3"><i class="fab fa-twitter"></i> Twitter</a>
        </div>
    </footer>

    <!-- Script to change the main image -->
    <script>
        function changeImage(src) {
            document.getElementById("main-image").src = src;
        }
    </script>

</body>
</html>
