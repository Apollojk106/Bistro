<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta tags para prevenir cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <title>Cardápio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animações suaves */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Efeito hover sutil */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Sticky navigation suave */
        .sticky-nav {
            transition: background-color 0.3s ease;
        }
        
        .sticky-nav.scrolled {
            background-color: rgba(46, 46, 46, 0.95);
            backdrop-filter: blur(10px);
        }
        
        /* Scroll personalizado */
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
        
        /* Badge de categoria */
        .category-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Placeholder para imagens */
        .image-placeholder {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 0.875rem;
        }
        
        /* Efeito de loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Classe para forçar reflow */
        .force-reflow {
            display: none !important;
        }
        
        /* Ajustes de responsividade para imagens */
        .card-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        
        @media (min-width: 768px) {
            .card-image {
                height: 200px;
            }
        }
        
        @media (min-width: 1024px) {
            .card-image {
                height: 220px;
            }
        }
        
        /* Ajuste para navegação de categorias em mobile */
        .category-scroll {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        .category-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" id="mainBody">

    <x-hotbar-user />

    <!-- Navegação de Categorias Sticky -->
    <nav id="categoryNav" class="sticky-nav sticky top-0 z-20 bg-[#2E2E2E] py-3 shadow-lg">
        <div class="container mx-auto px-2 sm:px-4">
            <div class="category-scroll flex overflow-x-auto space-x-3 md:space-x-4 lg:space-x-6 md:justify-center">
                @foreach ($cardapioPorCategoria as $categoria)
                <a href="#{{ Str::slug($categoria['categoria']) }}"
                   class="category-link flex-shrink-0 text-white hover:text-orange-400 px-3 py-2 text-sm md:text-base font-medium transition-all duration-300 whitespace-nowrap rounded-lg hover:bg-white/10"
                   onclick="selectNavItem(this, event)">
                    {{ $categoria['categoria'] }}
                </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container mx-auto px-3 sm:px-4 py-4 sm:py-6 md:py-8" id="mainContent">
        @foreach ($cardapioPorCategoria as $categoria)
        <section id="{{ Str::slug($categoria['categoria']) }}" 
                 class="category-section mb-8 md:mb-12 fade-in">
            
            <!-- Cabeçalho da Categoria -->
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">
                        {{ $categoria['categoria'] }}
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-1">
                        {{ count($categoria['itens']) }} itens disponíveis
                    </p>
                </div>
                
                <!-- Badge decorativo -->
                <div class="hidden sm:block">
                    <span class="category-badge bg-orange-100 text-orange-800">
                        {{ $categoria['categoria'] }}
                    </span>
                </div>
            </div>

            <!-- Grid de Itens - Ajustado para responsividade -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                @foreach ($categoria['itens'] as $cardapio)
                <article class="card-hover bg-white rounded-xl sm:rounded-2xl shadow-sm sm:shadow-md overflow-hidden border border-gray-100 hover:border-orange-200">
                    <a href="{{ route('item.get', $cardapio['id']) }}" class="block h-full" data-reload="true">
                        <!-- Imagem do Item - Mantendo estilo do segundo código -->
                        <div class="relative h-48 sm:h-52 overflow-hidden">
                            @if($cardapio['imagem'] && file_exists(public_path($cardapio['imagem'])))
                            <img src="{{ asset($cardapio['imagem']) }}"
                                 alt="{{ $cardapio['nome'] }}"
                                 class="card-image w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            @else
                            <!-- Placeholder com imagem padrão como no segundo código -->
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <img src="{{ asset('Icons/food.png') }}" 
                                     alt="Imagem padrão" 
                                     class="w-full h-full object-cover">
                            </div>
                            @endif
                            
                            <!-- Preço Overlay -->
                            <div class="absolute bottom-2 right-2 sm:bottom-4 sm:right-4">
                                <span class="bg-white/90 backdrop-blur-sm text-orange-600 font-bold py-1 px-2 sm:py-2 sm:px-4 rounded-full text-sm sm:text-base shadow">
                                    R$ {{ number_format($cardapio['valor'], 2, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Conteúdo do Card -->
                        <div class="p-3 sm:p-4 md:p-6">
                            <div class="flex items-start justify-between mb-2 sm:mb-3">
                                <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 pr-2 flex-1">
                                    {{ $cardapio['nome'] }}
                                </h3>
                                
                                <!-- Ícone de ação -->
                                <div class="flex-shrink-0 ml-2">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <p class="text-gray-600 text-xs sm:text-sm md:text-base mb-3 sm:mb-4 line-clamp-2">
                                {{ $cardapio['descricao'] }}
                            </p>

                            <!-- Botão de ação -->
                            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 sm:py-3 px-3 sm:px-4 rounded-lg transition-all duration-300 flex items-center justify-center group text-sm sm:text-base">
                                    <span>Ver detalhes</span>
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <!-- Linha decorativa entre categorias -->
            @if(!$loop->last)
            <div class="mt-8 md:mt-12 pt-6 md:pt-8 border-t border-gray-200">
                <div class="w-16 sm:w-20 md:w-24 h-0.5 sm:h-1 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full mx-auto"></div>
            </div>
            @endif
        </section>
        @endforeach

        <!-- CTA Final -->
        <div class="mt-8 md:mt-12 lg:mt-16 text-center">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl md:rounded-3xl p-6 md:p-8 lg:p-12 shadow-inner">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-3 md:mb-4">
                    🍽️ Bom apetite!
                </h3>
                <p class="text-gray-600 text-sm sm:text-base mb-4 sm:mb-6 max-w-2xl mx-auto px-2">
                    Esperamos que encontre algo delicioso! Se tiver alguma dúvida sobre nossos pratos, não hesite em perguntar.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                    <a href="#{{ Str::slug($cardapioPorCategoria[0]['categoria'] ?? 'destaques') }}"
                       class="bg-[#2E2E2E] hover:bg-gray-800 text-white font-semibold py-2 sm:py-3 px-6 sm:px-8 rounded-lg transition-all duration-300 text-sm sm:text-base">
                        Voltar ao topo
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Botão Flutuante para Voltar ao Topo -->
    <button id="backToTop"
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-[#2E2E2E] text-white p-2 sm:p-3 rounded-full shadow-xl hover:bg-gray-800 transition-all duration-300 opacity-0 invisible z-30 transform translate-y-4"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        // Função para corrigir o layout
        function fixBrokenLayout() {
            const body = document.getElementById('mainBody');
            const content = document.getElementById('mainContent');
            
            // Força reflow
            body.style.display = 'none';
            void body.offsetWidth;
            body.style.display = '';
            
            // Reseta o scroll
            window.scrollTo(0, 0);
            
            // Recalcula alturas
            document.querySelectorAll('.category-section').forEach(section => {
                section.style.height = 'auto';
                void section.offsetHeight;
            });
            
            console.log('Layout corrigido!');
        }
        
        // Controle do botão voltar ao topo
        function toggleBackToTop() {
            const backToTopBtn = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible', 'translate-y-4');
                backToTopBtn.classList.add('opacity-100', 'visible', 'translate-y-0');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible', 'translate-y-0');
                backToTopBtn.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        }
        
        // Controle da navegação sticky
        function toggleStickyNav() {
            const nav = document.getElementById('categoryNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }
        
        // Executa quando o DOM carrega
        document.addEventListener('DOMContentLoaded', function() {
            // Corrige layout
            fixBrokenLayout();
            setTimeout(fixBrokenLayout, 100);
            
            // Event listeners
            window.addEventListener('scroll', () => {
                toggleBackToTop();
                toggleStickyNav();
            });
            
            // Inicializa
            toggleBackToTop();
            toggleStickyNav();
            
            // Detecta quando a página volta do cache
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    setTimeout(fixBrokenLayout, 50);
                }
            });
            
            // Detecta mudanças de visibilidade
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    setTimeout(fixBrokenLayout, 150);
                }
            });
            
            // Corrige ao redimensionar
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(fixBrokenLayout, 250);
            });
            
            // Salva posição do scroll para links
            document.querySelectorAll('a[data-reload="true"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    sessionStorage.setItem('cardapioScrollPos', window.scrollY);
                });
            });
            
            // Restaura posição do scroll
            const savedScrollPos = sessionStorage.getItem('cardapioScrollPos');
            if (savedScrollPos) {
                setTimeout(() => {
                    window.scrollTo(0, parseInt(savedScrollPos));
                    sessionStorage.removeItem('cardapioScrollPos');
                }, 100);
            }
        });
        
        // Navegação por categorias
        function selectNavItem(element, event) {
            event.preventDefault();
            
            // Remove classes ativas de todos os links
            document.querySelectorAll('.category-link').forEach(link => {
                link.classList.remove('text-orange-400', 'bg-white/10');
                link.classList.add('text-white');
            });
            
            // Adiciona classe ativa ao link clicado
            element.classList.add('text-orange-400', 'bg-white/10');
            element.classList.remove('text-white');
            
            // Scroll suave para a seção
            const sectionId = element.getAttribute('href').substring(1);
            const section = document.getElementById(sectionId);
            
            if (section) {
                const offset = 70; // Ajuste para header sticky
                const elementPosition = section.offsetTop - offset;
                
                window.scrollTo({
                    top: elementPosition,
                    behavior: 'smooth'
                });
                
                // Atualiza URL sem recarregar
                history.pushState(null, null, `#${sectionId}`);
            }
        }
        
        // Atualiza navegação ativa durante o scroll
        function updateActiveNavOnScroll() {
            const sections = document.querySelectorAll('.category-section');
            const navLinks = document.querySelectorAll('.category-link');
            
            let currentSection = '';
            let scrollPosition = window.scrollY + 100; // Offset para ativação antecipada
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                const sectionId = section.getAttribute('id');
                
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    currentSection = sectionId;
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('text-orange-400', 'bg-white/10');
                link.classList.add('text-white');
                
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('text-orange-400', 'bg-white/10');
                    link.classList.remove('text-white');
                }
            });
        }
        
        // Adiciona listener para scroll
        window.addEventListener('scroll', updateActiveNavOnScroll);
    </script>

</body>

</html>