<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-white">

    <!-- Hotbar -->
    <x-hotbar-user />

    <!-- Navbar com botão de voltar -->
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>

    <!-- Conteúdo principal -->
    <div class="min-h-screen flex flex-col items-center p-4 pt-8">
        <!-- Mensagem "Obrigado!" fora do card cinza -->
        <div class="w-full max-w-md text-center mb-6 transition-all duration-300 ease-in-out transform hover:scale-105">
            <h1 class="text-2xl font-bold text-[#2E2E2E]">Obrigado!</h1>
            <p class="text-lg text-[#2E2E2E]">Em breve, seu pedido estará pronto.</p>
        </div>

        <!-- Card cinza -->
        <div class="w-full max-w-md bg-[#B7B7B7] rounded-2xl shadow-lg p-6 transition-all duration-300 ease-in-out transform hover:scale-105">
            <!-- Detalhes do pedido -->
            <div class="bg-gray p-6 rounded-xl">
                <!-- ID mais à esquerda -->
                <p class="text-lg font-bold text-[#2E2E2E] mb-2 ml-0">Nº<span class="text-sm align-top">14</span></p>

                <!-- Nome centralizado -->
                <div class="text-center">
                    <p class="text-xl font-semibold text-[#2E2E2E] mb-2">Apollo</p>
                </div>

                <!-- Restante dos dados alinhados à esquerda, mas com margem maior -->
                <div class="ml-4">
                    <p class="text-lg text-[#2E2E2E] mb-2">Bife com batata</p>
                    <p class="text-lg text-[#2E2E2E] mb-2">Para: 17:50</p>
                    <p class="text-lg text-[#2E2E2E] mb-2">Status: Pago</p>
                    <p class="text-lg text-[#2E2E2E] mb-4">Bife com batata, Coca 1L</p>
                </div>

                <!-- Ícone de relógio -->
                <div class="flex justify-center">
                    <img src="{{ asset('Icons/cloack.png') }}" alt="Relógio" class="w-16 h-16 transition-transform transform hover:scale-110">
                </div>
            </div>

            <!-- Botão Voltar -->
            <button class="w-full bg-[#A74A04] text-white font-semibold py-3 rounded-lg mt-6 hover:bg-[#8B3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Voltar
            </button>
        </div>
    </div>

</body>
</html>