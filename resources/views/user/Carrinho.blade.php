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
        <img class="h-[300px] sm:h-[150px] md:h-[400px] lg:h-[500px] w-full object-cover" src="{{ asset('Icons/food.png') }}" alt="Bife com batata frita">
        
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
</body>
</html>