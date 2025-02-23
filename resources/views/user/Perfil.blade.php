<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>

<body class="bg-gray-100 text-white">

    <x-hotbar-user />

    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4">
    </nav>

    <div class="w-auto h-auto flex justify-center items-center m-0">
        <img src="{{ asset('Icons/user.png') }}" alt="Imagem" class="border-4 border-[#2E2E2E] h-16 w-16  object-contain">
    </div>

    <div class="flex flex-col items-center justify-center h-full">
        <form class="h-full max-h-md p-6 rounded-lg " action="{{ route('User.Perfil') }}" method="get">
            <!-- Div que ocupa o resto da tela -->
            <div class="flex-grow p-4 max-h-screen m-4 rounded-lg bg-[#B7B7B7] m-4 ">
                <!-- Conteúdo da div do meio -->
                <p class="text-black text-center">"Nome"</p>

                <p class="text-black text-left">E-mail:</p>
                <input type="text" placeholder="Email..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Telefone:</p>
                <input type="text" placeholder="Senha..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">CEP:</p>
                <input type="text" placeholder="Email..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Numero de Residencia:</p>
                <input type="text" placeholder="Senha..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

            </div>
        </form>

        <p class="text-black text-center">Historico</p>

        <div class="swiper mySwiper mt-4">
            <div class="swiper-wrapper">
                <!-- Card 1 -->

                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-80 md:w-96 mt-2 mr-2">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition duration-300">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-80 md:w-96 mt-2 mr-2">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition duration-300">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>

                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-80 md:w-96 mt-2 mr-2">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition duration-300">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>


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