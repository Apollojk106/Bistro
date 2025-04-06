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
                <!-- Nome do Cliente -->
                <div class="text-center">
                    <p class="text-xl font-semibold text-[#2E2E2E] mb-2">{{ $pedido->nome }}</p>
                </div>

                <!-- Informações do Cliente -->
                <div class="ml-4 mb-4">
                    <p class="text-lg text-[#2E2E2E]"><strong>Email:</strong> {{ $pedido->email }}</p>
                    <p class="text-lg text-[#2E2E2E]"><strong>Telefone:</strong> {{ $pedido->telefone }}</p>
                    <p class="text-lg text-[#2E2E2E]"><strong>Endereço:</strong> {{ $pedido->rua }}, {{ $pedido->numero_residencia }} - {{ $pedido->bairro }}</p>
                    @if($pedido->complemento)
                    <p class="text-lg text-[#2E2E2E]"><strong>Complemento:</strong> {{ $pedido->complemento }}</p>
                    @endif
                </div>

                <!-- Iterando os Itens do Pedido -->
                <div class="border-t border-[#2E2E2E] pt-4 ml-4">
                    @foreach($pedido->itensPedido as $item)
                    <p class="text-lg text-[#2E2E2E]">
                        <strong>{{ $item->cardapio->nome }}</strong><br>
                        Qtd: {{ $item->quantidade }} -
                        R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}<br>
                        Subtotal: R$ {{ number_format($item->subtotal, 2, ',', '.') }}
                    </p>
                    @endforeach

                    <p class="text-lg font-bold text-[#2E2E2E] mt-4">
                        Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                    </p>
                    @if($pedido->frete != 0)
                    <p class="text-lg text-[#2E2E2E]">
                        Frete: R$ {{ number_format($pedido->frete, 2, ',', '.') }}
                    </p>
                    @endif
                    <p class="text-lg text-[#2E2E2E] mt-2">
                        Forma de Pagamento: {{ $pagamento }}
                    </p>
                    <p class="text-lg text-[#2E2E2E] mt-2">
                        Categoria: {{ ucfirst($pedido->categoria_pedido) }}
                    </p>
                    <p class="text-lg text-[#2E2E2E]">
                        Opção de Entrega: {{ ucfirst($pedido->opcao_entrega) }}
                    </p>
                    @if($pedido->horario)
                    <p class="text-lg text-[#2E2E2E] mb-2">
                        Agendado Para: {{ $pedido->horario }}
                    </p>
                    @endif
                    <p class="text-lg text-[#2E2E2E] mb-2">
                        Status: {{ ucfirst($pedido->status_pedido) }}
                    </p>
                </div>

                <!-- Ícone de relógio -->
                <div class="flex justify-center mt-4">
                    <img src="{{ asset('Icons/cloack.png') }}" alt="Relógio" class="w-16 h-16 transition-transform transform hover:scale-110">
                </div>
            </div>
        </div>
    </div>

</body>

</html>