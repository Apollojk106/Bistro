<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $Item->nome }} - Bistrô Terraço</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .checkbox-animation {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        
        .checkbox-animation:active {
            transform: scale(0.95);
        }
        
        .quantity-btn {
            width: 36px;
            height: 36px;
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
        
        /* Animação fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <x-hotbar-user />

    <!-- Header com imagem do item -->
    <div class="relative w-full overflow-hidden">
        <!-- Gradiente overlay para melhor legibilidade -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent z-10"></div>
        
        <!-- Imagem do item -->
        <img class="h-[300px] sm:h-[350px] md:h-[400px] w-full object-cover" 
             src="{{ asset($Item->imagem) }}" 
             alt="{{ $Item->nome }}"
             loading="lazy">
        
        <!-- Botão de voltar -->
        <button onclick="window.history.back();" 
                class="absolute top-6 left-6 z-20 bg-white/90 backdrop-blur-sm p-3 rounded-full shadow-lg hover:bg-white hover:shadow-xl smooth-transition">
            <img class="w-6 h-6" src="{{ asset('Icons/arrow-left-orange.png') }}" alt="Voltar">
        </button>
        
        <!-- Título sobre a imagem -->
        <div class="absolute bottom-6 left-6 right-6 z-20 text-white">
            <h1 class="text-2xl md:text-3xl font-bold mb-2 drop-shadow-lg">{{ $Item->nome }}</h1>
            <p class="text-white/90 text-sm md:text-base font-medium drop-shadow">
                R$ {{ number_format($Item->valor, 2, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Descrição do item -->
    <div class="bg-white px-6 py-6 animate-fade-in">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $Item->nome }}</h2>
                    <input type="hidden" class="main-id" value="{{ $Item->id }}" />
                </div>
                <div class="text-right">
                    <span class="text-green-600 font-bold text-2xl main-item-price"
                          data-price="{{ str_replace(',', '.', $Item->valor) }}">
                        R$ {{ number_format($Item->valor, 2, ',', '.') }}
                    </span>
                    <p class="text-gray-500 text-sm mt-1">Preço unitário</p>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h3 class="text-gray-700 font-semibold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Descrição
                </h3>
                <p class="text-gray-600">{{ $Item->descricao }}</p>
            </div>
        </div>
    </div>

    <!-- Adicionais -->
    @if(isset($Itens) && $Itens != null)
    <div class="px-6 py-4 bg-gray-50 animate-fade-in" style="animation-delay: 0.1s">
        <div class="max-w-4xl mx-auto">
            <!-- Título da seção -->
            <div class="flex items-center mb-6">
                <div class="h-8 w-1 bg-orange-500 rounded-full mr-3"></div>
                <h2 class="text-xl font-bold text-gray-900">Adicionais</h2>
                <span class="ml-3 bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full">
                    {{ count($Itens) }} opções
                </span>
            </div>
            
            <!-- Lista de adicionais -->
            <div class="space-y-4">
                @foreach($Itens as $Adicionais)
                <div class="item-container bg-white rounded-xl shadow-card hover:shadow-card-hover smooth-transition overflow-hidden border border-gray-100"
                     data-item-id="{{ $Adicionais->id }}">
                    <div class="flex items-center p-4">
                        <!-- Imagem -->
                        <div class="relative">
                            <img src="{{ asset($Adicionais->imagem) }}" 
                                 alt="{{ $Adicionais->nome }}" 
                                 class="w-20 h-20 rounded-lg object-cover">
                            <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow">
                                <span class="text-xs font-bold text-green-600">
                                    +R$ {{ number_format($Adicionais->valor, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Informações -->
                        <div class="flex-1 ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $Adicionais->nome }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $Adicionais->descricao }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-medium text-sm">
                                    Valor adicional: <span class="text-green-600 font-bold item-price" data-price="{{ $Adicionais->valor }}">
                                        +R$ {{ number_format($Adicionais->valor, 2, ',', '.') }}
                                    </span>
                                </span>
                                
                                <!-- Controles de quantidade -->
                                <div class="quantity-control hidden flex items-center space-x-3">
                                    <button class="decrease-btn quantity-btn text-lg">−</button>
                                    <span class="quantity-display font-bold text-gray-900 min-w-[24px] text-center">1</span>
                                    <button class="increase-btn quantity-btn text-lg">+</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Checkbox -->
                        <div class="item-checkbox ml-4 checkbox-animation">
                            <div class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center cursor-pointer smooth-transition hover:border-orange-400">
                                <svg class="checkbox-icon hidden w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Bebidas -->
    @if(isset($Bebidas) && $Bebidas != null)
    <div class="px-6 py-4 bg-white animate-fade-in" style="animation-delay: 0.2s">
        <div class="max-w-4xl mx-auto">
            <!-- Título da seção -->
            <div class="flex items-center mb-6">
                <div class="h-8 w-1 bg-blue-500 rounded-full mr-3"></div>
                <h2 class="text-xl font-bold text-gray-900">Bebidas</h2>
                <span class="ml-3 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                    {{ count($Bebidas) }} opções
                </span>
            </div>
            
            <!-- Lista de bebidas -->
            <div class="space-y-4">
                @foreach($Bebidas as $Bebida)
                <div class="item-container bg-white rounded-xl shadow-card hover:shadow-card-hover smooth-transition overflow-hidden border border-gray-100"
                     data-item-id="bebida-{{ $Bebida->id }}">
                    <div class="flex items-center p-4">
                        <!-- Imagem -->
                        <div class="relative">
                            <img src="{{ asset($Bebida->imagem) }}" 
                                 alt="{{ $Bebida->nome }}" 
                                 class="w-20 h-20 rounded-lg object-cover">
                            <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow">
                                <span class="text-xs font-bold text-green-600">
                                    +R$ {{ number_format($Bebida->valor, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Informações -->
                        <div class="flex-1 ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $Bebida->nome }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $Bebida->descricao }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-medium text-sm">
                                    Valor adicional: <span class="text-green-600 font-bold item-price" data-price="{{ $Bebida->valor }}">
                                        +R$ {{ number_format($Bebida->valor, 2, ',', '.') }}
                                    </span>
                                </span>
                                
                                <!-- Controles de quantidade -->
                                <div class="quantity-control hidden flex items-center space-x-3">
                                    <button class="decrease-btn quantity-btn text-lg">−</button>
                                    <span class="quantity-display font-bold text-gray-900 min-w-[24px] text-center">1</span>
                                    <button class="increase-btn quantity-btn text-lg">+</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Checkbox -->
                        <div class="item-checkbox ml-4 checkbox-animation">
                            <div class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center cursor-pointer smooth-transition hover:border-blue-400">
                                <svg class="checkbox-icon hidden w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Observação -->
    <div class="px-6 py-8 bg-gray-50 animate-fade-in" style="animation-delay: 0.3s">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-card p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <label for="observacao" class="text-gray-700 text-lg font-semibold">Observações do pedido</label>
                </div>
                <textarea id="observacao"
                    class="w-full p-4 mt-2 border-2 border-gray-200 rounded-lg text-gray-600 text-base focus:outline-none focus:border-orange-400 smooth-transition"
                    rows="4"
                    placeholder="Ex: Quero sem cebola, ponto da carne bem passado, sem palmito..."
                    onfocus="limparTexto()"
                    onblur="restaurarTexto()"></textarea>
                <p class="text-gray-500 text-sm mt-2">Essa informação será passada para nossa cozinha</p>
            </div>
        </div>
    </div>

    <!-- Espaço para o footer fixo -->
    <div class="h-40"></div>

    <!-- Footer fixo com resumo do pedido -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-50 animate-fade-in" style="animation-delay: 0.4s">
        <!-- Resumo do valor -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex justify-between items-center max-w-4xl mx-auto">
                <div>
                    <p class="text-gray-600 text-sm">Valor total</p>
                    <p class="text-gray-900 font-bold text-2xl">R$ <span id="total-price">{{ number_format($Item->valor, 2, ',', '.') }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Quantidade</p>
                    <div class="flex items-center space-x-4 mt-1">
                        <button id="decrease" class="quantity-btn text-lg">−</button>
                        <span id="quantity" class="text-gray-900 font-bold text-xl min-w-[32px] text-center">1</span>
                        <button id="increase" class="quantity-btn text-lg">+</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botão de ação -->
        <div class="px-6 py-4 bg-white">
            <div class="max-w-4xl mx-auto">
                <button id="openPopup" 
                        class="w-full gradient-orange hover:gradient-orange-hover text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Adicionar ao pedido
                </button>
            </div>
        </div>
    </div>

    <!-- Pop-up de confirmação -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden animate-fade-in">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-[90%] max-w-md mx-4">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Item adicionado!</h3>
                <p class="text-gray-600">O que você gostaria de fazer agora?</p>
            </div>
            
            <div class="space-y-4">
                <button onclick="saveToSession('/Cardapio'); return false;" 
                        class="w-full bg-white border-2 border-orange-500 text-orange-600 font-semibold py-3 px-6 rounded-xl hover:bg-orange-50 smooth-transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Continuar comprando
                </button>
                
                <button onclick="saveToSession('/Sacola'); return false;" 
                        class="w-full gradient-orange hover:gradient-orange-hover text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl smooth-transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Ver minha sacola
                </button>
            </div>
            
            <button onclick="document.getElementById('popup').classList.add('hidden')" 
                    class="w-full text-center text-gray-500 hover:text-gray-700 font-medium py-3 mt-6 smooth-transition">
                Fechar
            </button>
        </div>
    </div>

    <script>
        // Variáveis globais para controle do pedido
        let mainItem = {
            id: parseFloat(document.querySelector('.main-id').value),
            quantity: 1,
            price: parseFloat(document.querySelector('.main-item-price').getAttribute('data-price'))
        };

        let selectedItems = {};
        let selectedDrinks = {};

        document.addEventListener("DOMContentLoaded", function() {
            // Configuração de todos os itens
            document.querySelectorAll('.item-container').forEach(container => {
                const itemId = container.getAttribute('data-item-id');
                const checkbox = container.querySelector('.item-checkbox');
                const checkboxIcon = container.querySelector('.checkbox-icon');
                const quantityControl = container.querySelector('.quantity-control');
                const increaseBtn = container.querySelector('.increase-btn');
                const decreaseBtn = container.querySelector('.decrease-btn');
                const quantityDisplay = container.querySelector('.quantity-display');
                const price = parseFloat(container.querySelector('.item-price').getAttribute('data-price'));

                // Estado inicial
                let isChecked = false;
                let quantity = 1;

                // Configuração do checkbox
                checkbox.addEventListener('click', () => {
                    isChecked = !isChecked;

                    if (isChecked) {
                        // Mostra o ícone de check e muda a borda
                        checkboxIcon.classList.remove('hidden');
                        checkbox.querySelector('div').classList.add('border-orange-500', 'bg-orange-50');
                        quantityControl.classList.remove('hidden');
                        
                        // Efeito visual
                        checkbox.querySelector('div').style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            checkbox.querySelector('div').style.transform = 'scale(1)';
                        }, 150);

                        // Adiciona ao grupo correto
                        if (itemId.startsWith('bebida-')) {
                            selectedDrinks[itemId] = {
                                quantity: 1,
                                price: price
                            };
                        } else {
                            selectedItems[itemId] = {
                                quantity: 1,
                                price: price
                            };
                        }
                    } else {
                        // Esconde o ícone de check e restaura borda
                        checkboxIcon.classList.add('hidden');
                        checkbox.querySelector('div').classList.remove('border-orange-500', 'bg-orange-50');
                        quantityControl.classList.add('hidden');

                        // Remove do grupo correto
                        if (itemId.startsWith('bebida-')) {
                            delete selectedDrinks[itemId];
                        } else {
                            delete selectedItems[itemId];
                        }
                    }

                    updateTotal();
                });

                // Configuração dos botões de quantidade
                increaseBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    quantity++;
                    quantityDisplay.textContent = quantity;

                    if (isChecked) {
                        if (itemId.startsWith('bebida-')) {
                            selectedDrinks[itemId].quantity = quantity;
                        } else {
                            selectedItems[itemId].quantity = quantity;
                        }
                        updateTotal();
                    }
                });

                decreaseBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (quantity > 1) {
                        quantity--;
                        quantityDisplay.textContent = quantity;

                        if (isChecked) {
                            if (itemId.startsWith('bebida-')) {
                                selectedDrinks[itemId].quantity = quantity;
                            } else {
                                selectedItems[itemId].quantity = quantity;
                            }
                            updateTotal();
                        }
                    }
                });

                // Evita que o clique nos botões dispare o evento do checkbox
                quantityControl.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });

            // Controles do item principal
            document.getElementById("increase").addEventListener("click", function() {
                mainItem.quantity++;
                document.getElementById("quantity").textContent = mainItem.quantity;
                updateTotal();
            });

            document.getElementById("decrease").addEventListener("click", function() {
                if (mainItem.quantity > 1) {
                    mainItem.quantity--;
                    document.getElementById("quantity").textContent = mainItem.quantity;
                    updateTotal();
                }
            });

            // Configura popup
            const popup = document.getElementById("popup");
            document.getElementById("openPopup").addEventListener("click", function() {
                popup.classList.remove("hidden");
            });
            
            // Fechar popup ao clicar fora
            popup.addEventListener("click", function(event) {
                if (event.target === popup) {
                    popup.classList.add("hidden");
                }
            });
        });

        // Função para atualizar o total
        function updateTotal() {
            let total = mainItem.price * mainItem.quantity;

            // Soma os adicionais
            for (const itemId in selectedItems) {
                total += selectedItems[itemId].price * selectedItems[itemId].quantity;
            }

            // Soma as bebidas
            for (const drinkId in selectedDrinks) {
                total += selectedDrinks[drinkId].price * selectedDrinks[drinkId].quantity;
            }

            // Atualiza o display
            const formattedTotal = total.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('total-price').textContent = formattedTotal;

            return total;
        }

        // Funções para o campo de observação
        function limparTexto() {
            let campo = document.getElementById("observacao");
            if (campo.value === "Ex: Quero sem cebola, ponto da carne bem passado, sem palmito...") {
                campo.value = "";
                campo.classList.remove("text-gray-600");
                campo.classList.add("text-gray-800");
            }
        }

        function restaurarTexto() {
            let campo = document.getElementById("observacao");
            if (campo.value.trim() === "") {
                campo.value = "Ex: Quero sem cebola, ponto da carne bem passado, sem palmito...";
                campo.classList.remove("text-gray-800");
                campo.classList.add("text-gray-600");
            }
        }

        // Função para salvar na sessão
        function saveToSession($rota) {
            const observacao = document.getElementById('observacao').value;

            const orderData = {
                mainItem: {
                    id: mainItem.id,
                    quantity: mainItem.quantity,
                    price: mainItem.price
                },
                mainId: mainItem.id,
                selectedItems: selectedItems,
                selectedDrinks: selectedDrinks,
                observacao: observacao,
            };

            // Mostra loading no popup
            const popup = document.getElementById('popup');
            popup.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl p-8 w-[90%] max-w-md mx-4 text-center">
                    <div class="w-16 h-16 border-4 border-orange-200 border-t-orange-500 rounded-full animate-spin mx-auto mb-4"></div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Processando pedido...</h3>
                    <p class="text-gray-600">Por favor, aguarde um momento</p>
                </div>
            `;

            // Envia os dados via AJAX para o backend
            fetch("{{ route('salvar.pedido') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(orderData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = $rota;
                    } else {
                        // Restaura o popup original
                        setTimeout(() => {
                            window.location.href = data.redirect || '/Cardapio';
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error("Erro ao salvar pedido:", error);
                    // Restaura o popup original
                    setTimeout(() => {
                        window.location.href = '/Cardapio';
                    }, 1500);
                });
        }
    </script>
</body>
</html>