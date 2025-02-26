<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <x-hotbar-user />

    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="relative w-full">
        <!-- Ajuste a altura da imagem para telas maiores -->
        <img class="h-[400px] sm:h-[200px] md:h-[500px] lg:h-[600px] w-full object-cover" src="{{ asset('Icons/food.png') }}" alt="Bife com batata frita">
        
        <!-- Botão de voltar com ícone de imagem -->
        <button class="absolute top-4 left-4 bg-white p-3 rounded-full shadow-md hover:bg-gray-100 transition duration-200">
            <!-- Ícone de seta para a esquerda em laranja -->
            <img class="w-6 h-6" src="{{ asset('Icons/arrow-left-orange.png') }}" alt="Voltar">
        </button>
    </div>

    <div class="px-6 py-4">
        <h2 class="text-xl font-bold">Bife com batata frita</h2>
        <p class="text-gray-600 text-sm mt-2">Arroz soltinho, feijão temperado com alho e cebola, um bife suculento grelhado no ponto e batatas fritas crocantes. Uma combinação clássica e cheia de sabor.</p>
        <div class="flex items-center mt-4 space-x-2">
            <span class="text-green-600 font-bold text-lg">R$ 25,40</span>
            <span class="text-gray-400 line-through">R$ 30,40</span>
        </div>
    </div>

    <!-- Retângulo com texto -->
    <div class="w-full bg-[#C8C8C8] py-3 mt-4">
        <p class="pl-4 text-gray-900 font-medium">Escolha as opções de adicionais</p>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Batata frita com cheddar e bacon</h3>
                <p class="text-gray-600 text-sm">Batatas fritas douradas e crocantes, cobertas com uma generosa...</p>
                <span class="text-gray-900 font-medium">+R$ 25,40</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/food2.png') }}" alt="Batata frita com cheddar e bacon" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control1" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity1')" class="text-2xl font-bold">−</button>
                <span id="quantity1" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity1')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox1" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon1" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Salada com contra file</h3>
                <p class="text-gray-600 text-sm">Alface, tomate, cenoura ralada, e cebola com contra file</p>
                <span class="text-gray-900 font-medium">+R$ 19,00</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/food3.png') }}" alt="Salada com contra file" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control2" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity2')" class="text-2xl font-bold">−</button>
                <span id="quantity2" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity2')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox2" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon2" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Salada com file de frango</h3>
                <p class="text-gray-600 text-sm">Alface, tomate, cenoura ralada, e cebola com file de frango</p>
                <span class="text-gray-900 font-medium">+R$ 17,00</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/food4.png') }}" alt="Salada com file de frango" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control3" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity3')" class="text-2xl font-bold">−</button>
                <span id="quantity3" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity3')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox3" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon3" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Salada com omelete</h3>
                <p class="text-gray-600 text-sm">Alface, tomate, cenoura ralada, e cebola com omelete</p>
                <span class="text-gray-900 font-medium">+R$ 15,00</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/food5.png') }}" alt="Salada com omelete" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control4" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity4')" class="text-2xl font-bold">−</button>
                <span id="quantity4" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity4')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox4" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon4" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <div class="w-full bg-[#C8C8C8] py-3 mt-4">
        <p class="pl-4 text-gray-900 font-medium">Escolha as opções de bebida</p>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Coca-Cola</h3>
                <p class="text-gray-600 text-sm">Lata de coca-cola geladinha 250ml</p>
                <span class="text-gray-900 font-medium">+R$ 07,00</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/drink.png') }}" alt="Coca-Cola" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control5" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity5')" class="text-2xl font-bold">−</button>
                <span id="quantity5" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity5')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox5" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon5" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <!-- Opções de adicionais -->
    <div class="w-full bg-white py-3 px-4">
        <div class="flex items-center justify-between">
            <!-- Texto e descrição -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Coca-Cola 0</h3>
                <p class="text-gray-600 text-sm">Lata de coca-cola 0 geladinha 250ml</p>
                <span class="text-gray-900 font-medium">+R$ 07,00</span>
            </div>
            <!-- Imagem -->
            <img src="{{ asset('Icons/drink2.png') }}" alt="Coca-Cola 0" class="w-24 h-24 rounded-lg object-cover">
            <!-- Controles de quantidade (inicialmente escondidos) -->
            <div id="quantity-control6" class="hidden flex items-center space-x-4">
                <button onclick="decreaseQuantity('quantity6')" class="text-2xl font-bold">−</button>
                <span id="quantity6" class="text-lg">1</span>
                <button onclick="increaseQuantity('quantity6')" class="text-2xl font-bold">+</button>
            </div>
            <!-- Checkbox -->
            <div id="checkbox6" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon6" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <script>
        // Função para alternar o estado do checkbox e mostrar/ocultar controles de quantidade
        function toggleCheckbox(checkboxId, iconId, quantityControlId) {
            const checkbox = document.getElementById(checkboxId);
            const checkboxIcon = document.getElementById(iconId);
            const quantityControl = document.getElementById(quantityControlId);

            checkbox.addEventListener('click', () => {
                // Verifica se o checkbox está selecionado
                const isChecked = checkboxIcon.src.includes('check-green.png');

                // Altera o ícone do checkbox
                if (isChecked) {
                    checkboxIcon.src = "{{ asset('Icons/checkbox-empty.png') }}";
                    quantityControl.classList.add('hidden'); // Oculta os controles de quantidade
                } else {
                    checkboxIcon.src = "{{ asset('Icons/check-green.png') }}";
                    quantityControl.classList.remove('hidden'); // Mostra os controles de quantidade
                }

                // Mostra ou esconde o ícone
                checkboxIcon.classList.toggle('hidden');
            });
        }

        // Função para aumentar a quantidade
        function increaseQuantity(quantityId) {
            const quantityElement = document.getElementById(quantityId);
            let quantity = parseInt(quantityElement.innerText);
            quantity++;
            quantityElement.innerText = quantity;
        }

        // Função para diminuir a quantidade
        function decreaseQuantity(quantityId) {
            const quantityElement = document.getElementById(quantityId);
            let quantity = parseInt(quantityElement.innerText);
            if (quantity > 1) {
                quantity--;
                quantityElement.innerText = quantity;
            }
        }

        // Aplicar a função a cada checkbox
        toggleCheckbox('checkbox1', 'checkbox-icon1', 'quantity-control1');
        toggleCheckbox('checkbox2', 'checkbox-icon2', 'quantity-control2');
        toggleCheckbox('checkbox3', 'checkbox-icon3', 'quantity-control3');
        toggleCheckbox('checkbox4', 'checkbox-icon4', 'quantity-control4');
        toggleCheckbox('checkbox5', 'checkbox-icon5', 'quantity-control5');
        toggleCheckbox('checkbox6', 'checkbox-icon6', 'quantity-control6');
    </script>

<body class="pb-32"> <!-- Espaço no final para evitar sobreposição -->

    <!-- Conteúdo da página -->
    <div class="flex justify-center mt-6">
        <div class="w-96">
            <label for="observacao" class="block text-gray-700 text-lg font-semibold text-left">Observação</label>
            <textarea id="observacao" 
                      class="w-full p-3 mt-2 border rounded-lg border-[#c49a6c] text-gray-500 text-lg focus:outline-none focus:border-[#a6784c]" 
                      rows="4"
                      onfocus="limparTexto()" 
                      onblur="restaurarTexto()"
            >Sem feijão.</textarea>
        </div>
    </div>

    <!-- Espaço físico para empurrar o conteúdo para cima -->
    <div class="h-32"></div> <!-- Altura igual à altura do componente flutuante -->

    <script>
        function limparTexto() {
            let campo = document.getElementById("observacao");
            if (campo.value === "Sem feijão.") {
                campo.value = "";
                campo.classList.remove("text-gray-500");
                campo.classList.add("text-gray-800");
            }
        }

        function restaurarTexto() {
            let campo = document.getElementById("observacao");
            if (campo.value.trim() === "") {
                campo.value = "Sem feijão.";
                campo.classList.remove("text-gray-800");
                campo.classList.add("text-gray-500");
            }
        }
    </script>     

   <!-- Componente de valor total fixo no rodapé -->
<div class="fixed bottom-0 left-0 w-full bg-white border-t shadow-lg z-50">
    <div class="flex justify-between items-center p-2 bg-gray-300 rounded-t-lg">
        <span class="text-black font-medium">Valor total do pedido</span>
        <span class="text-black font-semibold">R$ <span id="total-price">49,40</span></span>
    </div>
    <div class="flex justify-between items-center p-4 bg-gray-300 rounded-b-lg">
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
                <button onclick="window.location.href='/Cardapio'" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2 mr-2">Continuar Comprando</button>
                <button onclick="window.location.href='/MeuPedido'" class="bg-[#a34702] text-white py-2 px-4 rounded-lg w-1/2">Ir para o pagamento</button>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let quantity = 1;
        let pricePerItem = 49.40;
        const quantityElement = document.getElementById("quantity");
        const totalPriceElement = document.getElementById("total-price");
        const popup = document.getElementById("popup");

        document.getElementById("increase").addEventListener("click", function () {
            quantity++;
            updateValues();
        });

        document.getElementById("decrease").addEventListener("click", function () {
            if (quantity > 1) {
                quantity--;
                updateValues();
            }
        });

        function updateValues() {
            quantityElement.textContent = quantity;
            totalPriceElement.textContent = (pricePerItem * quantity).toFixed(2).replace(".", ",");
        }

        // Mostrar o pop-up ao clicar no botão "Adicionar a sacola"
        document.getElementById("openPopup").addEventListener("click", function () {
            popup.classList.remove("hidden");
        });

        // Fechar pop-up ao clicar fora dele
        popup.addEventListener("click", function (event) {
            if (event.target === popup) {
                popup.classList.add("hidden");
            }
        });

        // Fechar pop-up ao clicar no botão "Continuar comprando"
        document.getElementById("continueShopping").addEventListener("click", function () {
            popup.classList.add("hidden");
        });

        // Aqui você pode adicionar a ação para "Ir para o pagamento"
        document.getElementById("goToPayment").addEventListener("click", function () {
            alert("Indo para o pagamento..."); // Substitua com a lógica real de redirecionamento
        });
    });
</script>


</body>
</body>
</html>