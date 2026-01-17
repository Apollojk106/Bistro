<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu e Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Adicione estes estilos para melhorar a responsividade */
        .header-responsive {
            height: auto;
            min-height: 80px;
        }
        
        @media (min-width: 768px) {
            .header-responsive {
                min-height: 100px;
            }
        }
        
        @media (min-width: 1024px) {
            .header-responsive {
                min-height: 120px;
            }
        }
        
        /* Melhorar o menu lateral para telas muito pequenas */
        @media (max-width: 640px) {
            #sideMenu {
                width: 100%;
                left: -100%;
            }
        }
        
        /* Prevenir problemas de scroll */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">
    
    <x-sweet-alert />

    <!-- Header CORRIGIDO -->
    <header class="bg-[#B7B7B7] header-responsive p-3 md:p-4 flex justify-between items-center relative">
        <!-- Ícone do menu hambúrguer - tamanhos responsivos -->
        <button id="menuToggle" 
                class="text-3xl md:text-4xl lg:text-5xl text-black bg-none border-none focus:outline-none p-2">
            &#9776;
        </button>

        <!-- Logo centralizada - tamanhos responsivos -->
        <a href="/" class="absolute left-1/2 transform -translate-x-1/2">
            <img src="{{ asset('Logo.png') }}" 
                 alt="Logo" 
                 class="h-16 w-auto md:h-20 lg:h-24 object-contain max-w-[180px] md:max-w-[220px] lg:max-w-[260px]">
        </a>

        <!-- Ícones do WhatsApp e Instagram - tamanhos responsivos -->
        <div class="flex space-x-2 md:space-x-3 lg:space-x-4">
            <button class="bg-none border-none focus:outline-none p-1">
                <img src="{{ asset('Icons/zap.png') }}" 
                     alt="WhatsApp" 
                     class="h-6 w-6 md:h-8 md:w-8 lg:h-10 lg:w-10 object-contain filter brightness-0 saturate-100">
            </button>
            <a href="https://instagram.com/bistro.terraco?igsh=a3l2ejV3azVyNTBz&utm_sourc" 
               target="_blank" 
               class="bg-none border-none focus:outline-none p-1">
                <img src="{{ asset('Icons/instagram.png') }}" 
                     alt="Instagram" 
                     class="h-6 w-6 md:h-8 md:w-8 lg:h-10 lg:w-10 object-contain filter brightness-0 saturate-100">
            </a>
        </div>
    </header>

    <!-- Menu Lateral CORRIGIDO -->
    <nav id="sideMenu" 
         class="fixed top-0 left-[-100%] w-full sm:w-64 h-full bg-[#B7B7B7] shadow-xl transition-all ease-in-out duration-300 pt-5 z-50 overflow-y-auto">
        
        <!-- Botão para fechar o menu -->
        <button id="closeMenu" 
                class="absolute top-3 right-4 text-3xl text-black bg-none border-none focus:outline-none p-2 hover:text-orange-600 transition-colors">
            &times;
        </button>

        <!-- Itens do menu -->
        <ul class="list-none p-0 mt-10 sm:mt-5">
            <li class="p-4 border-b border-gray-300 hover:bg-gray-200 transition-colors">
                <a href="{{ route('User.Cardapio') }}" 
                   class="text-lg flex items-center gap-3 text-black hover:text-orange-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Cardápio
                </a>
            </li>
            <li class="p-4 border-b border-gray-300 hover:bg-gray-200 transition-colors">
                <a href="{{ route('User.Sacola') }}" 
                   class="text-lg flex items-center gap-3 text-black hover:text-orange-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Carrinho
                </a>
            </li>
            <li class="p-4 border-b border-gray-300 hover:bg-gray-200 transition-colors">
                <a href="{{ route('User.Ultimo.Pedido') }}" 
                   class="text-lg flex items-center gap-3 text-black hover:text-orange-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Meu Pedido
                </a>
            </li>
            <li class="p-4 border-b border-gray-300 hover:bg-gray-200 transition-colors">
                <a href="{{ route('User.Localizacao') }}" 
                   class="text-lg flex items-center gap-3 text-black hover:text-orange-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Localização
                </a>
            </li>
            <li class="p-4 border-b border-gray-300 hover:bg-gray-200 transition-colors">
                <a href="{{ route('User.Perfil') }}" 
                   class="text-lg flex items-center gap-3 text-black hover:text-orange-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Perfil
                </a>
            </li>
        </ul>
        
        <!-- Rodapé do menu -->
        <div class="absolute bottom-0 w-full p-4 border-t border-gray-300 text-center">
            <p class="text-gray-600 text-sm">
                © {{ date('Y') }} Bistrô Terraço
            </p>
        </div>
    </nav>

    <!-- Overlay para fechar o menu -->
    <div id="menuOverlay" 
         class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"
         onclick="closeSideMenu()"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuToggle = document.getElementById("menuToggle");
            const sideMenu = document.getElementById("sideMenu");
            const closeMenu = document.getElementById("closeMenu");
            const menuOverlay = document.getElementById("menuOverlay");

            function openSideMenu() {
                sideMenu.classList.remove("left-[-100%]");
                sideMenu.classList.add("left-0");
                menuOverlay.classList.remove("hidden");
                menuOverlay.classList.add("opacity-0");
                setTimeout(() => {
                    menuOverlay.classList.remove("opacity-0");
                    menuOverlay.classList.add("opacity-100");
                }, 10);
                document.body.style.overflow = "hidden";
            }

            function closeSideMenu() {
                sideMenu.classList.remove("left-0");
                sideMenu.classList.add("left-[-100%]");
                menuOverlay.classList.remove("opacity-100");
                menuOverlay.classList.add("opacity-0");
                setTimeout(() => {
                    menuOverlay.classList.add("hidden");
                }, 300);
                document.body.style.overflow = "";
            }

            if (menuToggle && sideMenu && closeMenu && menuOverlay) {
                // Abrir menu
                menuToggle.addEventListener("click", (e) => {
                    e.stopPropagation();
                    openSideMenu();
                });

                // Fechar menu
                closeMenu.addEventListener("click", closeSideMenu);
                
                // Fechar menu ao clicar no overlay
                menuOverlay.addEventListener("click", closeSideMenu);

                // Fechar menu ao clicar em um link
                document.querySelectorAll('#sideMenu a').forEach(link => {
                    link.addEventListener('click', closeSideMenu);
                });

                // Fechar menu com tecla ESC
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && sideMenu.classList.contains('left-0')) {
                        closeSideMenu();
                    }
                });

                // Prevenir fechamento ao clicar dentro do menu
                sideMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
            
            // Corrigir layout ao carregar a página
            function fixLayoutOnLoad() {
                // Força um reflow para corrigir possíveis problemas
                document.body.style.display = 'none';
                document.body.offsetHeight; // Força reflow
                document.body.style.display = '';
                
                // Corrige altura do header
                const header = document.querySelector('header');
                if (header) {
                    header.style.height = 'auto';
                }
            }
            
            // Executa quando a página é carregada
            fixLayoutOnLoad();
            
            // Executa quando a página é mostrada novamente (quando volta de outra página)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    fixLayoutOnLoad();
                }
            });
            
            // Corrige layout ao redimensionar
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(fixLayoutOnLoad, 250);
            });
        });
        
        // Torna as funções globais para poder chamar de fora
        window.openSideMenu = function() {
            document.getElementById("sideMenu").classList.remove("left-[-100%]");
            document.getElementById("sideMenu").classList.add("left-0");
            document.getElementById("menuOverlay").classList.remove("hidden");
        };
        
        window.closeSideMenu = function() {
            document.getElementById("sideMenu").classList.remove("left-0");
            document.getElementById("sideMenu").classList.add("left-[-100%]");
            document.getElementById("menuOverlay").classList.add("hidden");
        };
    </script>
</body>

</html>