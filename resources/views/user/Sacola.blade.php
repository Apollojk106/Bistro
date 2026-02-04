<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Sacola - Bistrô Terraço</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Estilos personalizados */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .shadow-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .shadow-card-hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        .gradient-orange-hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        }
        
        .quantity-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
        }
        
        .quantity-btn:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }
        
        .quantity-btn:active {
            transform: translateY(0);
        }
        
        .remove-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .remove-btn:hover {
            background: #fecaca;
            transform: scale(1.1);
        }
        
        /* Animação fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c49a6c;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a6784c;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        /* Loader */
        .loader {
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <x-hotbar-user />

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Botão voltar -->
                <a href="javascript:history.back()" 
                   class="flex items-center text-gray-600 hover:text-orange-500 smooth-transition">
                    <i class="ph ph-arrow-left text-xl"></i>
                    <span class="ml-2 font-medium">Voltar</span>
                </a>
                
                <!-- Título -->
                <h1 class="text-xl font-bold text-gray-900">Minha Sacola</h1>
                
                <!-- Botão limpar -->
                <button id="open-popup" 
                        class="flex items-center text-red-500 hover:text-red-600 smooth-transition">
                    <i class="ph ph-trash text-lg"></i>
                    <span class="ml-2 font-medium hidden sm:inline">Limpar</span>
                </button>
            </div>
            
            <!-- Status do pedido -->
            @if(isset($Pedido) && $Pedido['quantidade'] > 0)
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="status-badge bg-green-100 text-green-800">
                            <i class="ph ph-shopping-cart mr-2"></i>
                            {{ $Pedido['quantidade'] }} itens
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Valor estimado</p>
                    <p class="text-xl font-bold text-green-600">R$ {{ number_format($Pedido['valor'] ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
            @endif
        </div>
    </header>

    <!-- Pop-up de confirmação -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-[90%] max-w-sm mx-4 animate-fade-in">
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="ph ph-warning text-2xl text-red-500"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Limpar sacola?</h3>
                <p class="text-gray-600 text-sm">Todos os itens serão removidos. Esta ação não pode ser desfeita.</p>
            </div>
            
            <div class="flex space-x-3">
                <button id="close-popup" 
                        class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-50 smooth-transition">
                    Cancelar
                </button>
                <button id="confirm-clear" 
                        class="flex-1 bg-red-500 text-white font-semibold py-3 px-4 rounded-xl hover:bg-red-600 smooth-transition">
                    Limpar tudo
                </button>
            </div>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <main class="container mx-auto px-4 py-6 pb-32">
        @if(isset($Carrinho) && !empty($Carrinho) && isset($Itens) && !empty($Itens))
        <!-- Lista de itens -->
        <div class="space-y-4">
            @foreach($Itens as $item)
            @php
            $id = $item->id;
            $quantidade = $Carrinho[$id]['quantidade'] ?? 1;
            $valor = $Carrinho[$id]['valor'] ?? $item->valor;
            $subtotal = $quantidade * $valor;
            @endphp

            <div class="item-container bg-white rounded-xl shadow-card hover:shadow-card-hover smooth-transition border border-gray-100 overflow-hidden animate-fade-in" 
                 id="item-{{ $id }}" 
                 data-item-id="{{ $id }}"
                 data-unit-price="{{ $valor }}"
                 style="animation-delay: {{ $loop->index * 0.05 }}s">
                <div class="p-4">
                    <div class="flex items-start">
                        <!-- Imagem -->
                        <div class="relative flex-shrink-0">
                            <img src="{{ asset($item->imagem) }}" 
                                 alt="{{ $item->nome }}" 
                                 class="w-20 h-20 rounded-lg object-cover">
                            <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow">
                                <span class="text-xs font-bold text-green-600 unit-price">
                                    R$ {{ number_format($valor, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Informações -->
                        <div class="flex-1 ml-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item->nome }}</h3>
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $item->descricao }}</p>
                                </div>
                                <!-- Botão remover -->
                                <button type="button" 
                                        onclick="removerItem({{ $id }})"
                                        class="remove-btn smooth-transition">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Controles de quantidade -->
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center space-x-3">
                                    <button type="button" 
                                            class="quantity-btn"
                                            onclick="decrementar({{ $id }})">
                                        <i class="ph ph-minus"></i>
                                    </button>
                                    <span class="font-bold text-gray-900 text-lg min-w-[32px] text-center quantity-display" 
                                          id="quantidade-span-{{ $id }}">
                                        {{ $quantidade }}
                                    </span>
                                    <button type="button" 
                                            class="quantity-btn"
                                            onclick="incrementar({{ $id }})">
                                        <i class="ph ph-plus"></i>
                                    </button>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Subtotal</p>
                                    <p class="text-lg font-bold text-green-600 subtotal-display" 
                                       id="subtotal-{{ $id }}">
                                        R$ {{ number_format($subtotal, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Estado vazio -->
        <div class="empty-state animate-fade-in">
            <div class="empty-state-icon">
                <i class="ph ph-shopping-cart text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Sua sacola está vazia</h3>
            <p class="text-gray-600 mb-6 max-w-md">
                Adicione itens deliciosos do nosso cardápio para começar seu pedido
            </p>
            <a href="{{ route('User.Cardapio') }}" 
               class="gradient-orange hover:gradient-orange-hover text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl smooth-transition">
                <i class="ph ph-utensils mr-2"></i>
                Ver cardápio
            </a>
        </div>
        @endif
    </main>

    <!-- Footer fixo -->
    @if(isset($Carrinho) && !empty($Carrinho) && isset($Itens) && !empty($Itens))
    <div class="fixed bottom-0 left-0 w-full bg-white border-t shadow-lg z-40 animate-fade-in" style="animation-delay: 0.3s">
        <div class="container mx-auto px-4 py-4">
            <!-- Formulário original com inputs hidden -->
            <form id="form-pedido" action="{{ route('salvar.sacola') }}" method="POST" class="space-y-3">
                @csrf
                
                <!-- Inputs hidden serão preenchidos dinamicamente -->
                <div id="hidden-inputs-container"></div>
                
                <!-- Resumo do pedido -->
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <p class="text-gray-600 text-sm">Total do pedido</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-pedido">
                            R$ {{ number_format($Pedido['valor'] ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 text-sm">Quantidade de itens</p>
                        <p class="text-lg font-bold text-gray-900" id="total-itens">
                            {{ $Pedido['quantidade'] ?? 0 }} itens
                        </p>
                    </div>
                </div>
                
                <!-- Botão finalizar -->
                <button type="submit" 
                        id="btn-finalizar"
                        class="w-full gradient-orange hover:gradient-orange-hover text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                    <i class="ph ph-credit-card mr-3 text-xl"></i>
                    <span id="submit-text">Finalizar pedido</span>
                    <div id="submit-loader" class="loader ml-3 hidden"></div>
                </button>
                
                <!-- Observação -->
                <div class="text-center">
                    <a href="{{ route('User.Cardapio') }}" 
                       class="inline-flex items-center text-orange-500 hover:text-orange-600 font-medium text-sm smooth-transition">
                        <i class="ph ph-plus-circle mr-2"></i>
                        Adicionar mais itens
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        // Funções para manipulação dos itens
        function incrementar(id) {
            let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
            let subtotalSpan = document.getElementById(`subtotal-${id}`);
            let container = document.getElementById(`item-${id}`);
            
            let quantidadeAtual = parseInt(quantidadeSpan.textContent);
            let unitPrice = parseFloat(container.getAttribute('data-unit-price'));
            
            let novoQuantidade = quantidadeAtual + 1;
            let novoSubtotal = (novoQuantidade * unitPrice);

            // Atualizar display
            quantidadeSpan.textContent = novoQuantidade;
            subtotalSpan.textContent = `R$ ${novoSubtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;

            atualizarTotal();
        }

        function decrementar(id) {
            let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
            let subtotalSpan = document.getElementById(`subtotal-${id}`);
            let container = document.getElementById(`item-${id}`);
            
            let quantidadeAtual = parseInt(quantidadeSpan.textContent);
            let unitPrice = parseFloat(container.getAttribute('data-unit-price'));

            if (quantidadeAtual > 1) {
                let novoQuantidade = quantidadeAtual - 1;
                let novoSubtotal = (novoQuantidade * unitPrice);

                // Atualizar display
                quantidadeSpan.textContent = novoQuantidade;
                subtotalSpan.textContent = `R$ ${novoSubtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
            } else {
                // Confirmação para remover item
                if (confirm('Deseja remover este item da sacola?')) {
                    document.getElementById(`item-${id}`).remove();
                }
            }

            atualizarTotal();
        }

        function removerItem(id) {
            if (confirm('Deseja remover este item da sacola?')) {
                document.getElementById(`item-${id}`).remove();
                atualizarTotal();
            }
        }

        function atualizarTotal() {
            let total = 0;
            let totalItens = 0;

            // Calcular baseado nos itens visíveis
            document.querySelectorAll('.item-container').forEach(item => {
                let id = item.getAttribute('data-item-id');
                let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
                let subtotalSpan = document.getElementById(`subtotal-${id}`);
                
                if (quantidadeSpan && subtotalSpan) {
                    let quantidade = parseInt(quantidadeSpan.textContent);
                    let subtotal = parseFloat(subtotalSpan.textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                    
                    total += subtotal;
                    totalItens += quantidade;
                }
            });

            // Atualizar o total e a quantidade de itens
            const totalPedido = document.getElementById('total-pedido');
            const totalItensSpan = document.getElementById('total-itens');
            
            if (totalPedido) {
                totalPedido.textContent = `R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
            }
            
            if (totalItensSpan) {
                const itemText = totalItens === 1 ? 'item' : 'itens';
                totalItensSpan.textContent = `${totalItens} ${itemText}`;
            }
            
            // Verifica se a sacola está vazia
            if (totalItens === 0) {
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }

        // Função para preparar e enviar o formulário
        function prepararEEnviarFormulario(e) {
            e.preventDefault(); // Previne o envio padrão
            
            const btn = document.getElementById("btn-finalizar");
            const submitText = document.getElementById("submit-text");
            const submitLoader = document.getElementById("submit-loader");
            const form = document.getElementById("form-pedido");
            const container = document.getElementById("hidden-inputs-container");
            
            // Calcular total de itens
            let totalItens = 0;
            document.querySelectorAll('.item-container').forEach(() => {
                totalItens++;
            });
            
            // Validação: Verificar se há itens no carrinho
            if (totalItens === 0) {
                alert('Adicione itens à sacola antes de finalizar o pedido.');
                return;
            }

            // Mostrar loading
            submitText.textContent = 'Processando...';
            submitLoader.classList.remove('hidden');
            btn.disabled = true;

            // Limpar inputs anteriores
            container.innerHTML = '';
            
            // Coletar dados atuais e criar inputs hidden
            let inputIndex = 0;
            document.querySelectorAll('.item-container').forEach(item => {
                let id = item.getAttribute('data-item-id');
                let quantidadeSpan = document.getElementById(`quantidade-span-${id}`);
                let subtotalSpan = document.getElementById(`subtotal-${id}`);
                
                if (quantidadeSpan && subtotalSpan) {
                    let quantidade = parseInt(quantidadeSpan.textContent);
                    let subtotal = parseFloat(subtotalSpan.textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                    let unitPrice = parseFloat(item.getAttribute('data-unit-price'));
                    
                    // Criar inputs hidden
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = `itens[${inputIndex}][id]`;
                    idInput.value = id;
                    
                    const quantidadeInput = document.createElement('input');
                    quantidadeInput.type = 'hidden';
                    quantidadeInput.name = `itens[${inputIndex}][quantidade]`;
                    quantidadeInput.value = quantidade;
                    
                    const valorInput = document.createElement('input');
                    valorInput.type = 'hidden';
                    valorInput.name = `itens[${inputIndex}][valor]`;
                    valorInput.value = unitPrice;
                    
                    const subtotalInput = document.createElement('input');
                    subtotalInput.type = 'hidden';
                    subtotalInput.name = `itens[${inputIndex}][subtotal]`;
                    subtotalInput.value = subtotal;
                    
                    // Adicionar ao container
                    container.appendChild(idInput);
                    container.appendChild(quantidadeInput);
                    container.appendChild(valorInput);
                    container.appendChild(subtotalInput);
                    
                    inputIndex++;
                }
            });
            
            // Enviar o formulário tradicionalmente
            setTimeout(() => {
                form.submit();
            }, 100);
            
            // Timeout de fallback (10 segundos)
            setTimeout(() => {
                submitText.textContent = 'Finalizar pedido';
                submitLoader.classList.add('hidden');
                btn.disabled = false;
                alert('Tempo esgotado. Por favor, tente novamente.');
            }, 10000);
        }

        // Popup de confirmação
        document.getElementById("open-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.remove("hidden");
        });

        document.getElementById("close-popup").addEventListener("click", function() {
            document.getElementById("popup").classList.add("hidden");
        });

        document.getElementById("confirm-clear").addEventListener("click", function() {
            window.location.href = "/Sacola/Limpar";
        });

        // Evento de submit do formulário
        document.getElementById("form-pedido")?.addEventListener("submit", prepararEEnviarFormulario);

        // Inicialização das animações
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona delay nas animações dos itens
            document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
</body>
</html>