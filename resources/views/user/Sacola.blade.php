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
        .fixed-bottom {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 428px;
            z-index: 1000;
            background-color: white;
            padding: 16px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .item-container {
            position: relative;
        }

        .remove-item {
            display: none;
            position: absolute;
            right: 0;
            top: 0;
            transform: translateY(-50%);
            background: white;
            border-radius: 50%;
            padding: 2px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 10;
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

    <form id="form-pedido" action="{{ route('salvar.sacola') }}" method="POST">
        @csrf
        <div class="bg-gray-100 p-6 pb-24">
            @if(isset($Carrinho) && !empty($Carrinho) && isset($Itens) && !empty($Itens))
            @foreach($Itens as $item)
            @php
            $id = $item->id;
            $quantidade = $Carrinho[$id]['quantidade'];
            $valor = $Carrinho[$id]['valor'];
            $subtotal = $quantidade * $valor;
            @endphp

            <!-- Inputs ocultos para envio -->
            <input type="hidden" name="itens[{{ $id }}][id]" value="{{ $id }}">
            <input type="hidden" name="itens[{{ $id }}][quantidade]" value="{{ $quantidade }}" id="input-quantidade-{{ $id }}">
            <input type="hidden" name="itens[{{ $id }}][valor]" value="{{ $valor }}">
            <input type="hidden" name="itens[{{ $id }}][subtotal]" value="{{ $subtotal }}" id="input-subtotal-{{ $id }}">

            <div class="border-b border-[#C8C8C8] mb-2 w-full"></div>
            <div class="item-container flex items-center border-b pb-8 mb-12" id="item-{{ $id }}">
                <img src="{{ asset($item->imagem) }}" alt="{{ $item->nome }}" class="w-28 h-28 rounded transition-transform transform hover:scale-110">
                <div class="ml-8 flex-1">
                    <h2 class="font-bold text-black">{{ $item->nome }}</h2><br>
                    <p class="text-green-600 font-semibold inline">R$ {{ number_format($valor, 2, ',', '.') }}</p>
                    <br>
                    <span class="text-gray-500 text-sm">Quantidade: <span id="quantidade-{{ $id }}">{{ $quantidade }}</span></span>
                </div>
                <div class="flex items-center bg-gray-200 rounded-full px-2 py-1 transition-all duration-300 ease-in-out hover:bg-gray-300">
                    <button type="button" class="p-1 text-orange-500 hover:text-orange-600" onclick="decrementar({{ $id }})">
                        <i id="icon-{{ $id }}" class="ph ph-minus"></i>
                    </button>
                    <span class="px-3 font-bold text-orange-500 text-sm" id="quantidade-span-{{ $id }}">{{ $quantidade }}</span>
                    <button type="button" class="p-1 text-orange-500 hover:text-orange-600" onclick="incrementar({{ $id }})">
                        <i class="ph ph-plus"></i>
                    </button>
                </div>
            </div>
            <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
            @endforeach
            @else
            <div class="text-center py-8">
                <p class="text-gray-600">Seu carrinho está vazio</p>
            </div>
            @endif
        </div>

        <!-- Botão "Continuar" fixo na parte inferior -->
        <div class="fixed-bottom">
            <div class="w-full bg-gray-300 rounded-2xl flex items-center justify-between px-4 py-3 transition-all duration-300 ease-in-out hover:shadow-lg">
                <div class="flex items-center space-x-2">
                    <p class="text-black text-lg font-semibold">R$ 64,40</p>
                    <span class="text-sm text-gray-700 text-center">2 itens</span>
                </div>
                <button type="submit" id="btn-finalizar" class="bg-orange-800 text-white text-base font-medium px-6 py-3 rounded-2xl hover:bg-orange-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                    Continuar
                </button>
            </div>
        </div>
    </form>

    <script>
        // Função para mostrar/ocultar o ícone de lixeira
        function toggleTrashIcon(id) {
            const quantidade = parseInt(document.getElementById(`quantidade-${id}`).textContent);
            const icon = document.getElementById(`icon-${id}`);
            const removeBtn = document.querySelector(`#item-${id} .remove-item`);

            if (quantidade === 1) {
                icon.className = "ph ph-trash";
                removeBtn.style.display = 'block';
            } else {
                icon.className = "ph ph-minus";
                removeBtn.style.display = 'none';
            }
        }

        function incrementar(id) {
            let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
            let inputQuantidade = document.getElementById(`input-quantidade-${id}`);
            let inputSubtotal = document.getElementById(`input-subtotal-${id}`);

            let quantidadeAtual = parseInt(quantidadeSpan.textContent);
            let novoQuantidade = quantidadeAtual + 1;

            quantidadeSpan.textContent = novoQuantidade;
            inputQuantidade.value = novoQuantidade;

            // Atualiza o subtotal (caso precise)
            let valorUnitario = parseFloat(inputQuantidade.getAttribute('value'));
            inputSubtotal.value = (novoQuantidade * valorUnitario).toFixed(2);
        }

        function decrementar(id) {
            let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
            let inputQuantidade = document.getElementById(`input-quantidade-${id}`);
            let inputSubtotal = document.getElementById(`input-subtotal-${id}`);

            let quantidadeAtual = parseInt(quantidadeSpan.textContent);
            if (quantidadeAtual > 1) {
                let novoQuantidade = quantidadeAtual - 1;
                quantidadeSpan.textContent = novoQuantidade;
                inputQuantidade.value = novoQuantidade;

                // Atualiza o subtotal (caso precise)
                let valorUnitario = parseFloat(inputQuantidade.getAttribute('value'));
                inputSubtotal.value = (novoQuantidade * valorUnitario).toFixed(2);
            }
        }

        function removerItem(id) {
            const item = document.getElementById(`item-${id}`);
            item.remove();
            atualizarTotal();
        }

        function atualizarTotal() {
            let total = 0;
            let totalItens = 0;

            document.querySelectorAll('.item-container').forEach(item => {
                let id = item.id.replace('item-', '');
                let quantidade = parseInt(document.getElementById(`quantidade-${id}`).textContent);
                let preco = parseFloat(item.querySelector('.text-green-600').textContent.replace('R$ ', '').replace(',', '.'));

                total += quantidade * preco;
                totalItens += quantidade;
            });

            // Atualiza o total e a quantidade de itens exibidos na tela
            document.querySelector('.fixed-bottom .text-lg').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
            document.querySelector('.fixed-bottom .text-sm').textContent = `${totalItens} itens`;
        }

        document.getElementById("open-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.remove("hidden");
        });

        document.getElementById("close-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.add("hidden");
        });

        document.getElementById("confirm-clear").addEventListener("click", function() {
            // Limpar todos os itens
            document.querySelectorAll('.item-container').forEach(item => {
                item.remove();
            });
            document.getElementById("popup").classList.add("hidden");
            atualizarTotal();
        });

        // Inicializa os ícones
        toggleTrashIcon(1);
        toggleTrashIcon(2);
    </script>
</body>

</html>