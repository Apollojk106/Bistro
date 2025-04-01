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
        <!-- Card cinza -->
        <div class="w-full max-w-md bg-[#B7B7B7] rounded-2xl shadow-lg p-6 transition-all duration-300 ease-in-out transform hover:scale-105">
            <div class="bg-gray p-6 rounded-xl">
                <!-- ID do Pedido -->
                <p class="text-lg font-bold text-[#2E2E2E] mb-2">Pedido Nº<span class="text-sm align-top">14</span></p>

                <!-- Nome do Cliente -->
                <div class="text-center">
                    <p class="text-xl font-semibold text-[#2E2E2E] mb-2">{{ $dadosPedido['User']['nome'] ?? 'Cliente' }}</p>
                </div>

                <!-- Iterando os Itens do Pedido -->
                <div class="ml-4">
                    @foreach($dadosPedido['carrinho'] as $id => $item)
                    @php
                    $produto = $produtos[$id] ?? null; // Verifica se o produto existe
                    @endphp

                    @if($produto)
                    <p class="text-lg text-[#2E2E2E]">
                        <strong>{{ $produto->nome }}</strong><br>Qtd: {{ $item['quantidade'] }} -
                        R$ {{ number_format($item['valor'], 2, ',', '.') }}
                    </p>
                    @endif
                    @endforeach

                    <p class="text-lg font-bold text-[#2E2E2E] mt-4">Total: R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>

                    <p class="text-lg text-[#2E2E2E] mt-2">Forma de Pagamento: {{ ucfirst($dadosPedido['pagamento']['metodo'] ?? 'não informado') }}</p>

                    <p class="text-lg text-[#2E2E2E] mt-2">Entrega: {{ $dadosPedido['opcoes']['categoria'] ?? 'local' }}</p>
                    @if(isset($dadosPedido['opcoes']['horario']) )
                    <p class="text-lg text-[#2E2E2E] mb-2">Para: {{ $dadosPedido['opcoes']['horario']}}</p>
                    @endif
                    <p class="text-lg text-[#2E2E2E] mb-2">Status do pagamento: Pendente</p>
                </div>

                <!-- Ícone de relógio -->
                <div class="flex justify-center">
                    <img src="{{ asset('Icons/cloack.png') }}" alt="Relógio" class="w-16 h-16 transition-transform transform hover:scale-110">
                </div>
            </div>

            <!-- Botão Pedir -->
            <button onclick="mostrarPopup()" class="w-full bg-[#A74A04] text-white font-semibold py-3 rounded-lg mt-6 hover:bg-[#8B3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Pedir
            </button>

            <!-- Popup de Confirmação -->
            <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white border-2 border-black rounded-2xl p-6 w-80 shadow-lg text-center">
                    <p class="text-black text-lg font-semibold">Deseja confirmar seu pedido?</p>
                    <div class="flex justify-between mt-4">
                        <!-- Botão para Fechar o Popup -->
                        <button onclick="fecharPopup()" class="bg-gray-500 text-white py-2 px-4 rounded-lg w-1/2 mr-2">Não</button>

                        <!-- Botão para Confirmar o Pedido -->
                        <button onclick="confirmarPedido()" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    function mostrarPopup() {
        document.getElementById("popup").classList.remove("hidden");
    }

    function fecharPopup() {
        document.getElementById("popup").classList.add("hidden");
    }

    function confirmarPedido() {
        window.location.href = "{{ route('Gerar.Pedido') }}";
    }
</script>

</html>