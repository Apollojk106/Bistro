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
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white p-8 rounded-2xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105">
            <!-- Título mais para cima -->
            <h2 class="text-2xl font-bold text-left mb-9 text-[#A74A04] transition-all duration-300 ease-in-out transform hover:scale-105">Opção de Pagamento</h2>

            <!-- Opções de pagamento -->
            <div class="space-y-6">
                <!-- PIX -->
                <div onclick="selecionarPagamento('pix')" class="flex items-center justify-between border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Icons/pix.png') }}" alt="Pix" class="w-10 h-10 transition-transform transform hover:scale-110">
                        <span class="text-xl font-semibold flex items-center">Pix</span>
                    </div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center transition-colors duration-300 ease-in-out" id="circle-pix">
                        <img id="check-pix" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                    </div>
                </div>

                <!-- Cartão -->
                <div onclick="selecionarPagamento('cartao')" class="flex items-center justify-between border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Icons/card.png') }}" alt="Cartão" class="w-10 h-10 transition-transform transform hover:scale-110">
                        <span class="text-xl font-semibold flex items-center">Cartão</span>
                    </div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center transition-colors duration-300 ease-in-out" id="circle-cartao">
                        <img id="check-cartao" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                    </div>
                </div>

                <!-- Dinheiro -->
                <div onclick="selecionarPagamento('dinheiro')" class="border rounded-lg p-6 cursor-pointer hover:bg-gray-50 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('Icons/cash.png') }}" alt="Dinheiro" class="w-10 h-10 transition-transform transform hover:scale-110">
                            <span class="text-xl font-semibold flex items-center">Dinheiro</span>
                        </div>
                        <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center transition-colors duration-300 ease-in-out" id="circle-dinheiro">
                            <img id="check-dinheiro" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="w-6 h-6 hidden">
                        </div>
                    </div>

                    <!-- Campo de troco (só aparece quando selecionado) -->
                    <div id="troco-opcao" class="mt-4 hidden">
                        <label class="block text-sm font-semibold text-left mb-2">Troco para:</label>
                        <input type="text" id="troco-input" placeholder="EX: 50" class="w-full bg-gray-200 p-3 rounded-md text-center transition-all duration-300 ease-in-out focus:ring-2 focus:ring-[#A74A04] focus:outline-none">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé com valor total -->
    <div class="bg-[#B7B7B7] flex justify-between items-center px-6 py-6 mt-12 fixed bottom-0 w-full transition-all duration-300 ease-in-out transform hover:scale-105">
        <span class="font-semibold text-lg">R$ {{ $Pedido['valor'] ?? '0,00' }}</span>
        <span class="text-sm text-gray-600 ml-2">{{ $Pedido['quantidade'] ?? '0' }} itens</span>
        <form action="{{ route('User.Pagamento.Post') }}" method="post">
            @csrf
            <input type="hidden" name="metodo_pagamento" id="metodo-pagamento-input">
            <input type="hidden" name="troco_para" id="troco-para-input">

            <button type="submit" class="bg-[#A74A04] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#8B3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Continuar
            </button>
        </form>
    </div>

    <script>
        function selecionarPagamento(tipo) {
            // Esconde todos os checkmarks e reseta os círculos
            ['pix', 'cartao', 'dinheiro'].forEach(opcao => {
                document.getElementById('check-' + opcao).classList.add('hidden');
                document.getElementById('circle-' + opcao).classList.remove('border-[#A74A04]');
                document.getElementById('circle-' + opcao).classList.add('border-gray-400');
            });

            // Mostra apenas o checkmark da opção selecionada e muda a borda do círculo
            document.getElementById('check-' + tipo).classList.remove('hidden');
            document.getElementById('circle-' + tipo).classList.remove('border-gray-400');
            document.getElementById('circle-' + tipo).classList.add('border-[#A74A04]');

            // Atualiza o valor do campo hidden para enviar a opção selecionada via POST
            document.getElementById('metodo-pagamento-input').value = tipo;

            // Controla a exibição do campo de troco
            const trocoOpcao = document.getElementById('troco-opcao');
            const trocoInput = document.getElementById('troco-input');

            if (tipo === 'dinheiro') {
                trocoOpcao.classList.remove('hidden');
                // Foca no campo de troco quando dinheiro é selecionado
                setTimeout(() => trocoInput.focus(), 100);
            } else {
                trocoOpcao.classList.add('hidden');
                // Limpa o valor do troco se outro método for selecionado
                trocoInput.value = '';
                document.getElementById('troco-para-input').value = '';
            }
        }

        // Atualiza o campo hidden do troco quando o usuário digita
        document.getElementById('troco-input').addEventListener('input', function(e) {
            document.getElementById('troco-para-input').value = e.target.value;
        });

        // Opcional: Formata o valor do troco para moeda
        document.getElementById('troco-input').addEventListener('blur', function(e) {
            const value = parseFloat(e.target.value.replace(',', '.'));
            if (!isNaN(value)) {
                e.target.value = value.toFixed(2).replace('.', ',');
                document.getElementById('troco-para-input').value = value.toFixed(2);
            }
        });
    </script>

</body>

</html>