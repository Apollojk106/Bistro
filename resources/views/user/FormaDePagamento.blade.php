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
                <!-- PIX (estático) -->
                <div onclick="selecionarPagamento('pix')" class="flex items-center justify-between border rounded-lg p-6 cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Icons/pix.png') }}" alt="Pix" class="w-10 h-10">
                        <span class="text-xl font-semibold">Pix</span>
                    </div>
                    <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-pix">
                        <img id="check-pix" src="{{ asset('Icons/check-green.png') }}" class="w-6 h-6 hidden">
                    </div>
                </div>

                <!-- Dinheiro (estático) -->
                <div onclick="selecionarPagamento('dinheiro')" class="border rounded-lg p-6 cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('Icons/cash.png') }}" alt="Dinheiro" class="w-10 h-10">
                            <span class="text-xl font-semibold">Dinheiro</span>
                        </div>
                        <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-dinheiro">
                            <img id="check-dinheiro" src="{{ asset('Icons/check-green.png') }}" class="w-6 h-6 hidden">
                        </div>
                    </div>
                    <div id="troco-opcao" class="mt-4 hidden">
                        <label class="block text-sm font-semibold text-left mb-2">Troco para:</label>
                        <input type="text" id="troco-input" placeholder="EX: 50" class="w-full bg-gray-200 p-3 rounded-md text-center">
                    </div>
                </div>

                <!-- Cartão (estático) com opções dinâmicas -->
                <div class="border rounded-lg p-6 hover:bg-gray-50">
                    <div onclick="selecionarPagamento('cartao')" class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('Icons/card.png') }}" alt="Cartão" class="w-10 h-10">
                            <span class="text-xl font-semibold">Cartão</span>
                        </div>
                        <div class="w-8 h-8 border-2 border-gray-400 rounded-full flex justify-center items-center" id="circle-cartao">
                            <img id="check-cartao" src="{{ asset('Icons/check-green.png') }}" class="w-6 h-6 hidden">
                        </div>
                    </div>

                    <!-- Opções de cartão (dinâmicas) -->
                    <div id="opcoes-cartao" class="mt-4 hidden space-y-3 pl-4">
                        @foreach($opcoesCartao as $opcao)
                        <div onclick="selecionarOpcaoCartao(event, '{{ $opcao->id }}', '{{ $opcao->nome }}')"
                            class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-100">
                            <span>{{ $opcao->nome }}</span>
                            <div class="w-6 h-6 border-2 border-gray-300 rounded-full" id="circle-opcao-{{ $opcao->id }}"></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé com valor total -->
    <div class="bg-[#B7B7B7] flex justify-between items-center px-6 py-6 mt-12 fixed bottom-0 w-full transition-all duration-300 ease-in-out transform hover:scale-105">
        <span class="font-semibold text-lg">R$ {{ $Pedido['valor'] ?? '0,00' }}</span>
        <span class="text-sm text-gray-600 ml-2">{{ $Pedido['quantidade'] ?? '0' }} itens</span>
        <form action="{{ route('User.Pagamento.Post') }}" method="post" id="pagamento-form">
            @csrf
            <input type="hidden" name="metodo_pagamento" id="metodo-pagamento-input">
            <input type="hidden" name="opcao_cartao" id="opcao-cartao-input">
            <input type="hidden" name="troco_para" id="troco-para-input">

            <button type="submit" class="bg-[#A74A04] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#8B3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Continuar
            </button>
        </form>
    </div>


    <script>
        let metodoSelecionado = null;
        let opcaoCartaoSelecionada = null;

        function selecionarPagamento(tipo) {
            // Resetar seleções
            document.querySelectorAll('[id^="circle-"]').forEach(el => {
                el.classList.remove('border-[#A74A04]', 'bg-[#A74A04]');
            });
            document.querySelectorAll('[id^="check-"]').forEach(el => {
                el.classList.add('hidden');
            });

            // Marcar como selecionado
            document.getElementById(`check-${tipo}`).classList.remove('hidden');
            document.getElementById(`circle-${tipo}`).classList.add('border-[#A74A04]');

            // Gerenciar exibição
            if (tipo === 'dinheiro') {
                document.getElementById('troco-opcao').classList.remove('hidden');
                document.getElementById('opcoes-cartao').classList.add('hidden');
            } else if (tipo === 'cartao') {
                document.getElementById('opcoes-cartao').classList.remove('hidden');
                document.getElementById('troco-opcao').classList.add('hidden');
            } else {
                document.getElementById('opcoes-cartao').classList.add('hidden');
                document.getElementById('troco-opcao').classList.add('hidden');
            }

            // Atualizar formulário
            metodoSelecionado = tipo;
            opcaoCartaoSelecionada = null;
            document.getElementById('metodo-pagamento-input').value = tipo;
            document.getElementById('opcao-cartao-input').value = '';
        }

        function selecionarOpcaoCartao(event, id, nome) {
            event.stopPropagation();

            // Resetar seleções de opções
            document.querySelectorAll('[id^="circle-opcao-"]').forEach(el => {
                el.classList.remove('bg-[#A74A04]');
            });

            // Marcar opção selecionada
            document.getElementById(`circle-opcao-${id}`).classList.add('bg-[#A74A04]');

            // Atualizar formulário
            opcaoCartaoSelecionada = {
                id,
                nome
            };
            document.getElementById('opcao-cartao-input').value = id;
        }

        function toggleTrocoField() {
            const precisaTroco = document.getElementById('precisa-troco').checked;
            const trocoField = document.getElementById('troco-field');

            if (precisaTroco) {
                trocoField.classList.remove('hidden');
                setTimeout(() => document.getElementById('troco-input').focus(), 100);
            } else {
                trocoField.classList.add('hidden');
                document.getElementById('troco-input').value = '';
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

        // Permite o envio do formulário mesmo sem troco preenchido
        document.querySelector('form').addEventListener('submit', function(e) {
            // Se o método for dinheiro e o checkbox de troco estiver marcado mas o campo vazio
            if (document.getElementById('metodo-pagamento-input').value === 'dinheiro' &&
                document.getElementById('troco-input').value.trim() === '') {
                document.getElementById('troco-para-input').value = 0;
            }
        });
    </script>

</body>

</html>