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
            <!-- Checkbox -->
            <div id="checkbox" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>

    <script>
        // Função para alternar o estado do checkbox
        const checkbox = document.getElementById('checkbox');
        const checkboxIcon = document.getElementById('checkbox-icon');

        checkbox.addEventListener('click', () => {
            // Verifica se o checkbox está selecionado
            const isChecked = checkboxIcon.src.includes('checkbox.png');

            // Altera o ícone do checkbox
            if (isChecked) {
                checkboxIcon.src = "{{ asset('Icons/checkbox-empty.png') }}";
            } else {
                checkboxIcon.src = "{{ asset('Icons/check-green.png') }}";
            }

            // Mostra ou esconde o ícone
            checkboxIcon.classList.toggle('hidden');
        });
    </script>


   



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
            <img src="{{ asset('Icons/food3.png') }}" alt="Batata frita com cheddar e bacon" class="w-24 h-24 rounded-lg object-cover">
            <!-- Checkbox -->
            <div id="checkbox" class="w-8 h-8 border-2 border-gray-900 rounded-full flex items-center justify-center ml-4 cursor-pointer">
                <img id="checkbox-icon" src="{{ asset('Icons/checkbox-empty.png') }}" alt="Checkbox" class="w-6 h-6 hidden">
            </div>
        </div>
        <!-- Linha que cobre de um lado ao outro -->
        <div class="border-b border-[#C8C8C8] mt-2 w-full"></div>
    </div>










</body>
</html>