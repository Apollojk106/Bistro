<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para o scroll horizontal */
        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 20px 10px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        .scroll-container::-webkit-scrollbar {
            height: 6px;
        }
        
        .scroll-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        
        .scroll-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        
        .scroll-container::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }
        
        .card {
            min-width: 260px;
            flex: 0 0 auto;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-image {
            height: 160px;
            object-fit: cover;
            width: 100%;
        }
        
        .category-title {
            color: #2E2E2E;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            text-align: center;
            width: 100%;
        }
        
        .category-section {
            scroll-margin-top: 80px; /* Espaço para a hotbar fixa */
        }
    </style>
</head>

<body class="bg-gray-100">

    <x-hotbar-user />

    <!-- Navegação Principal com fundo preto -->
    <nav class="flex justify-center py-4 sticky top-0 z-10 bg-[#2E2E2E]">
        <div class="flex space-x-6">
            <a href="#pastel" class="text-white hover:text-orange-500 px-4 py-2 text-lg font-medium transition-all duration-300" onclick="selectNavItem(this)">Pastel</a>
            <a href="#pratos-do-dia" class="text-white hover:text-orange-500 px-4 py-2 text-lg font-medium transition-all duration-300" onclick="selectNavItem(this)">Pratos do dia</a>
            <a href="#tapioca" class="text-white hover:text-orange-500 px-4 py-2 text-lg font-medium transition-all duration-300" onclick="selectNavItem(this)">Tapioca</a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-4 md:p-6">
        @foreach ($cardapioPorCategoria as $categoria)
        <section id="{{ Str::slug($categoria['categoria']) }}" class="category-section mb-16">
            <h2 class="category-title">{{ $categoria['categoria'] }}</h2>

            <div class="scroll-container">
                @foreach ($categoria['itens'] as $cardapio)
                <div class="card">
                    <a href="{{ route('item.get', $cardapio['id']) }}" class="block h-full">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col border border-gray-200">
                            <img src="{{ asset($cardapio['imagem'] ?? 'Icons/food.png') }}" 
                                 alt="{{ $cardapio['nome'] }}" 
                                 class="card-image">
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800 text-center">{{ $cardapio['nome'] }}</h3>
                                <p class="text-gray-600 text-sm mt-2 text-center flex-grow">{{ $cardapio['descricao'] }}</p>
                                <p class="text-orange-500 font-bold mt-4 text-center">R$ {{ number_format($cardapio['valor'], 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </main>

    <script>
        // Seleção de item no menu - apenas cor laranja e scroll para seção
        function selectNavItem(element) {
            // Remove a classe de todos os itens
            document.querySelectorAll('nav a').forEach(a => {
                a.classList.remove('text-orange-500');
            });
            
            // Adiciona a classe apenas no item clicado
            element.classList.add('text-orange-500');
            
            // Obtém o ID da seção a partir do href
            const sectionId = element.getAttribute('href').substring(1);
            
            // Encontra a seção correspondente
            const section = document.getElementById(sectionId);
            
            // Se a seção existir, faz o scroll suave até ela
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Ativa a primeira categoria por padrão
        document.addEventListener('DOMContentLoaded', function() {
            const firstNavItem = document.querySelector('nav a');
            if (firstNavItem) {
                firstNavItem.classList.add('text-orange-500');
            }
        });
    </script>

    <script src="js/app.js"></script>

</body>
</html>