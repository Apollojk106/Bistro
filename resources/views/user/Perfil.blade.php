<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para o scroll horizontal */
        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 20px 10px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-container::-webkit-scrollbar {
            height: 6px;
        }

        .scroll-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        .card {
            min-width: 260px;
            flex: 0 0 auto;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            height: 160px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100 text-white">

    <x-hotbar-user />

    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4">
    </nav>

    <div class="w-auto h-auto flex justify-center items-center m-0">
        <img src="{{ asset('Icons/user.png') }}" alt="Imagem" class="border-4 border-[#2E2E2E] h-16 w-16 object-contain transition-transform transform hover:scale-110">
    </div>

    <div class="flex flex-col items-center justify-center h-full">
        <!-- Formulário de Perfil -->
        <form action="{{route('User.Save.Perfil')}}" method="post" class="w-full max-w-sm bg-[#B7B7B7] p-6 rounded-lg shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105">
            @csrf
            <div class="space-y-6">
                <!-- Nome -->
                <div class="flex justify-between items-center">
                    <p class="text-black text-left font-medium">Nome:</p>
                    <!-- Ícone de edição -->
                    <svg class="w-6 h-6 cursor-pointer transition-transform transform hover:scale-110 text-[#A74A04]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="enableEditing()">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <input type="text" id="nome" name="nome" value="{{ $usuario->nome }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                <!-- Telefone -->
                <p class="text-black text-left font-medium">Telefone:</p>
                <input type="text" id="telefone" name="telefone" value="{{ $usuario->telefone }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                <!-- Dropdown de Endereço -->
                <div class="mt-4">
                    <div class="flex justify-between items-center cursor-pointer" onclick="toggleAddress()">
                        <p class="text-black text-left font-semibold">Endereço</p>
                        <svg id="addressArrow" class="w-6 h-6 transform transition-transform duration-300 text-[#A74A04]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <!-- Campos de Endereço -->
                    <div id="addressFields" class="hidden mt-2 space-y-4">
                        <!-- CEP -->
                        <p class="text-black text-left">CEP:</p>
                        <input type="text" id="cep" name="cep" value="{{ $usuario->cep }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <!-- Rua -->
                        <p class="text-black text-left">Rua:</p>
                        <input type="text" id="rua" name="rua" value="{{ $usuario->rua }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <!-- Bairro -->
                        <p class="text-black text-left">Bairro:</p>
                        <input type="text" id="bairro" name="bairro" value="{{ $usuario->bairro }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <!-- Número de Residência -->
                        <p class="text-black text-left">Número de Residência:</p>
                        <input type="text" id="numero_residencia" name="numero_residencia" value="{{ $usuario->numero_residencia }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />

                        <!-- Complemento -->
                        <p class="text-black text-left">Complemento:</p>
                        <input type="text" id="complemento" name="complemento" value="{{ $usuario->complemento }}" class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" disabled />
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

        <!-- Container de Cards com scroll horizontal -->
        <div class="scroll-container w-full max-w-4xl flex gap-4 overflow-x-auto py-4">
            @foreach($PedidosUser as $pedido)
            @php
            $primeiroItem = $pedido->itensPedido->first();
            $cardapio = $primeiroItem?->cardapio;
            @endphp

            <div class="card min-w-[250px]">
                <form method="post" action="/Historico/id">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pedido->id }}">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col border border-gray-200">
                        <img src="{{ $cardapio && $cardapio->imagem ? asset('storage/' . $cardapio->imagem) : asset('Icons/food.png') }}" alt="{{ $cardapio->nome ?? 'Prato' }}" class="card-image h-40 object-cover">
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800 text-center">{{ $cardapio->nome ?? 'Prato não identificado' }}</h3>
                            <p class="text-gray-600 text-sm mt-2 text-center">{{ $cardapio->descricao ?? 'Sem descrição disponível' }}</p>
                            <p class="text-orange-500 font-bold mt-4 text-center">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                        </div>
                        <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                            <span class="text-white font-bold">Pedir Novamente</span>
                        </button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        // Função para habilitar a edição dos campos
        function enableEditing() {
            const inputs = document.querySelectorAll('input');
            const saveButton = document.getElementById('saveButton');

            inputs.forEach(input => {
                input.disabled = false;
            });

            saveButton.classList.remove('hidden');
        }

        // Função para alternar a visibilidade dos campos de endereço
        function toggleAddress() {
            const addressFields = document.getElementById('addressFields');
            const addressArrow = document.getElementById('addressArrow');

            addressFields.classList.toggle('hidden');
            addressArrow.classList.toggle('rotate-180');
        }
    </script>

    <script src="js/app.js"></script>

</body>

</html>