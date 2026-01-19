<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 text-gray-900">
    <x-hotbar-user />

    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="relative w-full">
        <!-- Ajuste a altura da imagem para telas maiores -->
        <img class="h-[400px] sm:h-[200px] md:h-[500px] lg:h-[600px] w-full object-cover" src="{{ asset($Item->imagem) }}" alt="Bife com batata frita">

        <!-- Botão de voltar com ícone de imagem -->
        <button onclick="window.history.back();" class="absolute top-4 left-4 bg-white p-3 rounded-full shadow-md hover:bg-gray-100 transition duration-200">
            <!-- Ícone de seta para a esquerda em laranja -->
            <img class="w-6 h-6" src="{{ asset('Icons/arrow-left-orange.png') }}" alt="Voltar">
        </button>
    </div>

    <div class="px-6 py-4">
        <h2 class="text-xl font-bold">{{$Item->nome}}</h2>
        <input type="hidden" class="main-id" value="{{$Item->id}}" />
        <p class="text-gray-600 text-sm mt-2">{{$Item->descricao}}</p>
        <div class="flex items-center mt-4 space-x-2">
            <span class="text-green-600 font-bold text-lg main-item-price"
                data-price="{{ str_replace(',', '.', $Item->valor) }}">R$ {{$Item->valor}}</span>
        </div>
    </div>

    @if(isset($Itens) && $Itens != null)
    <!-- Retângulo com texto -->
    <div class="w-full bg-[#C8C8C8] py-3 mt-4">
        <p class="pl-4 text-gray-900 font-medium">Escolha as opções de adicionais</p>
    </div>

    <!-- Opções de adicionais -->
    @foreach($Itens as $Adicionais)
    <div class="w-full bg-white py-3 px-4 item-container" data-item-id="{{$Adicionais->id}}">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">{{$Adicionais->nome}}</h3>
                <p class="text-gray-600 text-sm">{{$Adicionais->descricao}}</p>
                <span class="text-gray-900 font-medium item-price" data-price="{{$Adicionais->valor}}">+R$ {{$Adicionais->valor}}</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset($Adicionais->imagem) }}" alt="Batata frita com cheddar e bacon" class="w-24 h-24 rounded-lg object-cover">

            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div class="quantity-control hidden flex items-center space-x-4">
                <button class="decrease-btn text-2xl font-bold">−</button>
                <span class="quantity-display text-lg">1</span>
                <button class="increase-btn text-2xl font-bold">+</button>
            </div>

            <!-- Checkbox -->
            <div class="item-checkbox w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img class="checkbox-icon w-6 h-6 hidden" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>
    @endforeach
    @endif

    <!-- Linha que cobre de um lado ao outro -->
    <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>

    @if(isset($Bebidas) && $Bebidas != null)
    <div class="w-full bg-[#C8C8C8] py-3 mt-4">
        <p class="pl-4 text-gray-900 font-medium">Escolha as opções de bebida</p>
    </div>

    <!-- Opções de adicionais -->
    @foreach($Bebidas as $Bebida)
    <div class="w-full bg-white py-3 px-4 item-container" data-item-id="bebida-{{$Bebida->id}}">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">{{$Bebida->nome}}</h3>
                <p class="text-gray-600 text-sm">{{$Bebida->descricao}}</p>
                <span class="text-gray-900 font-medium item-price" data-price="{{$Bebida->valor}}">+R$ {{$Bebida->valor}}</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset($Bebida->imagem) }}" alt="{{$Bebida->nome}}" class="w-24 h-24 rounded-lg object-cover">

            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div class="quantity-control hidden flex items-center space-x-4">
                <button class="decrease-btn text-2xl font-bold">−</button>
                <span class="quantity-display text-lg">1</span>
                <button class="increase-btn text-2xl font-bold">+</button>
            </div>

            <!-- Checkbox -->
            <div class="item-checkbox w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img class="checkbox-icon w-6 h-6 hidden" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>
    @endforeach
    @endif

    <div class="pb-32"> <!-- Espaço no final para evitar sobreposição -->
        <!-- Conteúdo da página -->
        <div class="flex justify-center mt-6">
            <div class="w-96">
                <label for="observacao" class="block text-gray-700 text-lg font-semibold text-left">Observação</label>
                <textarea id="observacao"
                    class="w-full p-3 mt-2 border rounded-lg border-[#c49a6c] text-gray-500 text-lg focus:outline-none focus:border-[#a6784c]"
                    rows="4"
                    placeholder="Quero um dos pratos sem feijão..."
                    onfocus="limparTexto()"
                    onblur="restaurarTexto()"></textarea>
            </div>
        </div>

        <!-- Espaço físico para empurrar o conteúdo para cima -->
        <div class="h-32"></div> <!-- Altura igual à altura do componente flutuante -->
    </div>

    <!-- Componente de valor total fixo no rodapé -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t shadow-lg z-50">
        <div class="flex justify-between items-center p-2 bg-gray-300 rounded-t-lg">
            <span class="text-black font-medium">Valor total do pedido</span>
            <span class="text-black font-semibold">R$ <span id="total-price">{{ number_format($Item->valor, 2, ',', '.') }}</span></span>
        </div>
        <div class="flex justify-between items-center p-4 bg-gray-300 rounded-b-lg">
            <span class="text-black font-medium">Item Principal</span>

            <div class="flex items-center space-x-4">
                <button id="decrease" class="text-xl">−</button>
                <span id="quantity" class="text-black font-medium">1</span>
                <button id="increase" class="text-xl">+</button>
            </div>
            <button id="openPopup" class="bg-[#a34702] text-white py-2 px-4 rounded-xl">Adicionar a sacola</button>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white border-2 border-black rounded-2xl p-6 w-80 shadow-lg text-center">
            <p class="text-black text-lg font-semibold">E agora qual o próximo passo?</p>
            <div class="flex justify-between mt-4">
                <button onclick="saveToSession('/Cardapio'); return false;" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2 mr-2">Continuar Comprando</button>
                <button onclick="saveToSession('/Sacola'); return false;" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2">Ir para o pagamento</button>
            </div>
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
                        // Mostra o ícone de check
                        checkboxIcon.classList.remove('hidden');
                        quantityControl.classList.remove('hidden');

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
                        // Esconde o ícone de check
                        checkboxIcon.classList.add('hidden');
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
            if (campo.value === "Quero um dos pratos sem feijão...") {
                campo.value = "";
                campo.classList.remove("text-gray-500");
                campo.classList.add("text-gray-800");
            }
        }

        function restaurarTexto() {
            let campo = document.getElementById("observacao");
            if (campo.value.trim() === "") {
                campo.value = "Quero um dos pratos sem feijão...";
                campo.classList.remove("text-gray-800");
                campo.classList.add("text-gray-500");
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
                        sessionStorage.setItem('cardapio_error', data.error_code);
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error("Erro ao salvar pedido:", error);
                    alert("Erro ao salvar.", error);
                });
        }
    </script>
</body>

</html>