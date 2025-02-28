<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma De Pagamento</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Hotbar -->
    <x-hotbar-user />

    <!-- Navbar com botão de voltar -->
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <!-- Título mais para cima -->
            <h2 class="text-2xl font-bold text-left mb-8 text-[#A74A04]">Opção de Pagamento</h2>

            <!-- Opções de pagamento -->
            <div class="space-y-6">
                <!-- PIX -->
                <div onclick="selecionarPagamento('pix')" class="flex items-center justify-between border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Icons/pix.png') }}" alt="Pix" class="w-10 h-10">
                        <span class="text-xl font-semibold flex items-center">Pix</span>
                    </div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-pix">
                        <img id="check-pix" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                    </div>
                </div>

                <!-- Cartão -->
                <div onclick="selecionarPagamento('cartao')" class="flex items-center justify-between border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Icons/card.png') }}" alt="Cartão" class="w-10 h-10">
                        <span class="text-xl font-semibold flex items-center">Cartão</span>
                    </div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-cartao">
                        <img id="check-cartao" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                    </div>
                </div>

                <!-- Dinheiro -->
                <div onclick="selecionarPagamento('dinheiro')" class="border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('Icons/cash.png') }}" alt="Dinheiro" class="w-10 h-10">
                            <span class="text-xl font-semibold flex items-center">Dinheiro</span>
                        </div>
                        <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-dinheiro">
                            <img id="check-dinheiro" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                        </div>
                    </div>

                    <!-- Campo de troco (só aparece quando selecionado) -->
                    <div id="troco-opcao" class="mt-4 hidden">
                        <label class="block text-sm font-semibold text-left mb-2">Troco para:</label>
                        <input type="text" placeholder="EX: 50" class="w-full bg-gray-200 p-3 rounded-md text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé com valor total -->
    <div class="bg-[#B7B7B7] flex justify-between items-center px-6 py-6 mt-12 fixed bottom-0 w-full">
        <span class="text-xl font-bold text-black">R$ 64,40</span>
        <span class="text-sm text-black">2 itens</span>
        <button class="bg-[#A74A04] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#8B3D03] transition-all">
            Continuar
        </button>
    </div>

    <script>
        function selecionarPagamento(tipo) {
            // Esconde todos os checkmarks e reseta os círculos
            ['pix', 'cartao', 'dinheiro'].forEach(opcao => {
                document.getElementById('check-' + opcao).classList.add('hidden');
                document.getElementById('circle-' + opcao).classList.replace('border-[#A74A04]', 'border-gray-400');
            });

            // Mostra apenas o checkmark da opção selecionada e muda a borda do círculo
            document.getElementById('check-' + tipo).classList.remove('hidden');
            document.getElementById('circle-' + tipo).classList.replace('border-gray-400', 'border-[#A74A04]');

            // Controla a exibição do campo de troco
            if (tipo === 'dinheiro') {
                document.getElementById('troco-opcao').classList.remove('hidden');
            } else {
                document.getElementById('troco-opcao').classList.add('hidden');
            }
        }
    </script>

</body>
</html>