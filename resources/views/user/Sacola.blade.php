<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeuPedido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Estilo para o botão "Continuar" fixo na parte inferior */
        .fixed-bottom {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 428px; /* Largura máxima do botão */
            z-index: 1000; /* Garante que o botão fique acima de outros elementos */
            background-color: white; /* Fundo branco para evitar transparência */
            padding: 16px; /* Espaçamento interno */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Sombra para destacar */
        }
    </style>
</head>
<body class="bg-gray-100 text-white h-full">
    <x-hotbar-user />
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
        <div class="flex space-x-10">
            <!-- Seus outros itens de navegação aqui -->
        </div>
    </nav>

    <!-- Cabeçalho da Sacola -->
    <div class="bg-white py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-semibold mx-auto text-black">Sacola</h1>
        <button class="text-red-600 transition-transform transform hover:scale-110" id="open-popup">
            <img src="{{ asset('Icons/trash-red.png') }}" alt="Lixeira" class="w-6 h-6">
        </button>
    </div>

    <!-- Itens do pedido -->
    <div class="mt-4 px-6">
        <h2 class="text-lg font-medium text-black text-left md:text-center">Itens do pedido</h2>
    </div>

    <!-- Pop-up de confirmação -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white border-2 border-black rounded-2xl p-6 w-80 shadow-lg text-center transition-all duration-300 ease-in-out transform hover:scale-105">
            <p class="text-black text-lg font-semibold">Você tem certeza que deseja limpar a sacola?</p>
            <div class="flex justify-between mt-4">
                <button id="confirm-clear" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2 mr-2 transition-all duration-300 ease-in-out hover:bg-[#8a3c00]">Limpar</button>
                <button id="close-popup" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2 transition-all duration-300 ease-in-out hover:bg-[#8a3c00]">Voltar</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("open-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.remove("hidden");
        });
        
        document.getElementById("close-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.add("hidden");
        });
    </script>

    <div class="bg-gray-100 p-6 pb-24"> <!-- Adicionado pb-24 para espaço extra no final -->

            <!-- Item 1 -->
            <div class="flex items-center border-b pb-8 mb-12">
                <img src="{{ asset('Icons/food.png') }}" alt="Bife com batata" class="w-28 h-28 rounded transition-transform transform hover:scale-110">
                <div class="ml-8 flex-1">
                    <h2 class="font-bold text-black">Bife com batata</h2><br>
                    <p class="text-green-600 font-semibold inline">R$ 49,40</p>
                    <span class="text-gray-400 line-through ml-2">R$ 54,40</span><br>
                    <p class="text-gray-500 text-sm flex items-center"><span class="bg-gray-200 px-2 py-1 rounded-full mr-2">1</span> Coca-Cola 0</p>
                    <p class="text-gray-500 text-sm flex items-center"><span class="bg-gray-200 px-2 py-1 rounded-full mr-2">1</span> Salada com filé de frango</p>
                    <a href="#" class="text-[#BE3816] font-semibold transition-all duration-300 ease-in-out hover:text-[#9c2c0e]">Editar o pedido</a>
                </div>
                <div class="flex items-center bg-gray-200 rounded-full px-2 py-1 transition-all duration-300 ease-in-out hover:bg-gray-300">
                    <button class="p-1 text-orange-500 hover:text-orange-600" onclick="decrementar(1)">
                        <i id="icon-1" class="ph ph-minus"></i>
                    </button>
                    <span id="quantidade-1" class="px-3 font-bold text-orange-500 text-sm">1</span>
                    <button class="p-1 text-orange-500 hover:text-orange-600" onclick="incrementar(1)">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
            </div>
            
            <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>

            <!-- Item 2 -->
            <div class="flex items-center pt-8">
                <img src="{{ asset('Icons/food5.png') }}" alt="Salada com omelete" class="w-28 h-28 rounded transition-transform transform hover:scale-110">
                <div class="ml-8 flex-1">
                    <h2 class="font-bold text-black">Salada com omelete</h2><br>
                    <p class="text-green-600 font-semibold">R$ 15,00</p><br>
                    <a href="#" class="text-[#BE3816] font-semibold transition-all duration-300 ease-in-out hover:text-[#9c2c0e]">Editar o pedido</a>
                </div>
                <div class="flex items-center bg-gray-200 rounded-full px-2 py-1 transition-all duration-300 ease-in-out hover:bg-gray-300">
                    <button class="p-1 text-orange-500 hover:text-orange-600" onclick="decrementar(2)">
                        <i id="icon-2" class="ph ph-minus"></i>
                    </button>
                    <span id="quantidade-2" class="px-3 font-bold text-orange-500 text-sm">1</span>
                    <button class="p-1 text-orange-500 hover:text-orange-600" onclick="incrementar(2)">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão "Continuar" fixo na parte inferior -->
    <div class="fixed-bottom">
        <div class="w-full bg-gray-300 rounded-2xl flex items-center justify-between px-4 py-3 transition-all duration-300 ease-in-out hover:shadow-lg">
            <div class="flex items-center space-x-2">
                <p class="text-black text-lg font-semibold">R$ 64,40</p>
                <span class="text-sm text-gray-700 text-center">2 itens</span>
            </div>
            <button onclick="window.location.href='/Selecao'" class="bg-orange-800 text-white text-base font-medium px-6 py-3 rounded-2xl hover:bg-orange-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                Continuar
            </button>
        </div>
    </div>

    <script>
        function incrementar(id) {
            let quantidade = document.getElementById(`quantidade-${id}`);
            let icon = document.getElementById(`icon-${id}`);
            let valor = parseInt(quantidade.textContent);
            quantidade.textContent = valor + 1;

            // Atualiza o ícone para "menos" se o valor for maior que 1
            if (valor + 1 > 1) {
                icon.className = "ph ph-minus";
            }
        }

        function decrementar(id) {
            let quantidade = document.getElementById(`quantidade-${id}`);
            let icon = document.getElementById(`icon-${id}`);
            let valor = parseInt(quantidade.textContent);

            if (valor > 1) {
                quantidade.textContent = valor - 1;
                icon.className = "ph ph-minus"; // Ícone de menos
            } else {
                quantidade.textContent = 1;
                icon.className = "ph ph-trash"; // Ícone de lixo
            }
        }
    </script>
</body>
</html>