<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>
<body class="bg-gray-100 text-white">

    <x-hotbar-user />

    <!-- Navegação Principal -->
    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4">

        <a href="#" class="text-white hover:text-orange-500 px-3 py-2 rounded-md text-lg font-medium" onclick="selectNavItem(this)">Pastel</a>
        <a href="#" class="text-white hover:text-orange-500 px-3 py-2 rounded-md text-lg font-medium" onclick="selectNavItem(this)">Pratos do dia</a>
        <a href="#" class="text-white hover:text-orange-500 px-3 py-2 rounded-md text-lg font-medium" onclick="selectNavItem(this)">Tapioca</a>
    </nav>

    <main class="max-w-6xl mx-auto p-6 text-center">
        <h2 class="text-2xl font-bold mb-8 text-black">Pratos do dia</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Card 1 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-80 md:w-96">
                    <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                        <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                        <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-80 md:w-96">
                    <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                        <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                        <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </main>

    <script>
        function selectNavItem(element) {
            document.querySelectorAll('nav a').forEach(a => a.classList.remove('text-orange-500'));
            element.classList.add('text-orange-500');
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/app.js"></script>

</body>
</html>
