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
        <img src="{{ asset('Icons/user.png') }}" alt="Imagem" class="border-4 border-[#2E2E2E] h-16 w-16 object-contain transition-transform transform hover:scale-110">
    </div>

    <div class="flex flex-col items-center justify-center h-full">
        <!-- Formulário de Perfil (mais estreito) -->
        <form class="w-full max-w-sm bg-[#B7B7B7] p-6 rounded-lg shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105" action="{{ route('User.Perfil') }}" method="get">
            <div class="space-y-6"> <!-- Espaçamento vertical mantido -->
                <!-- Nome -->
                <div class="flex justify-between items-center">
                    <p class="text-black text-left font-medium">Nome:</p>
                    <!-- Ícone de edição (laranja) -->
                    <svg class="w-6 h-6 cursor-pointer transition-transform transform hover:scale-110 text-[#A74A04]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="toggleEdit()">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Nome..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                <!-- E-mail -->
                <p class="text-black text-left font-medium">E-mail:</p>
                <input type="text" placeholder="Email..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                <!-- Telefone -->
                <p class="text-black text-left font-medium">Telefone:</p>
                <input type="text" placeholder="Telefone..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                <!-- Dropdown de Endereço -->
                <div class="mt-4">
                    <div class="flex justify-between items-center cursor-pointer" onclick="toggleAddress()">
                        <p class="text-black text-left font-semibold">Endereço</p>
                        <!-- Ícone de seta (laranja) -->
                        <svg id="addressArrow" class="w-6 h-6 transform transition-transform duration-300 text-[#A74A04]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <!-- Campos de Endereço (inicialmente ocultos) -->
                    <div id="addressFields" class="hidden mt-2 space-y-4">
                        <p class="text-black text-left">CEP:</p>
                        <input type="text" placeholder="CEP..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <p class="text-black text-left">Rua:</p>
                        <input type="text" placeholder="Rua..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <p class="text-black text-left">Bairro:</p>
                        <input type="text" placeholder="Bairro..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <p class="text-black text-left">Número de Residência:</p>
                        <input type="text" placeholder="Número de Residência..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <p class="text-black text-left">Complemento:</p>
                        <input type="text" placeholder="Complemento..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />
                    </div>
                </div>

                <!-- Botão de salvar edição -->
                <div class="flex justify-center mt-4">
                    <button type="submit" id="saveButton" class="bg-[#A74A04] text-white px-4 py-2 rounded-lg hidden hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">Salvar Edição</button>
                </div>
            </div>
        </form>

        <!-- Título do Histórico -->
        <p class="text-black text-center text-xl font-semibold mt-8 transition-all duration-300 ease-in-out transform hover:scale-105">Histórico</p>

        <!-- Swiper de Cards -->
        <div class="swiper mySwiper mt-4 w-full max-w-md">
            <div class="swiper-wrapper">
                <!-- Card 1 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-72 md:w-80 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-32 sm:h-40 md:h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-72 md:w-80 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-32 sm:h-40 md:h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>

                <!-- Card 3 -->
                <div class="swiper-slide bg-white shadow-lg rounded-lg overflow-hidden w-72 md:w-80 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <form method="post" action="#">
                        <input type="hidden" name="id" value="valor_do_id">
                        <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-full h-32 sm:h-40 md:h-48 object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-xl font-semibold text-black">Bife com batata</h3>
                            <p class="text-gray-600 text-sm mt-2">Arroz, feijão, batata frita crocante...</p>
                            <p class="text-orange-500 font-bold mt-4">R$ 25,00</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para alternar a edição dos campos
        function toggleEdit() {
            const inputs = document.querySelectorAll('input');
            const saveButton = document.getElementById('saveButton');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
            });

            saveButton.classList.toggle('hidden');
        }

        // Função para alternar a visibilidade dos campos de endereço
        function toggleAddress() {
            const addressFields = document.getElementById('addressFields');
            const addressArrow = document.getElementById('addressArrow');

            addressFields.classList.toggle('hidden');
            addressArrow.classList.toggle('rotate-180');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>