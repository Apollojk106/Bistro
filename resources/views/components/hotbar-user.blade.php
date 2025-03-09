<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu e Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-[#B7B7B7] h-40 p-4 flex justify-between items-center relative">
        <!-- Ícone do menu hambúrguer -->
        <button id="menuToggle" class="text-4xl text-black bg-none border-none focus:outline-none md:text-5xl lg:text-6xl">
            &#9776;
        </button>

        <!-- Logo centralizada -->
        <a href="/" class="absolute left-1/2 transform -translate-x-1/2">
            <img src="Logo.png" alt="Logo" class="h-24 md:h-32 object-contain">
        </a>

        <!-- Ícones do WhatsApp e Instagram -->
        <div class="flex space-x-4">
            <button class="bg-none border-none focus:outline-none">
                <img src="{{ asset('Icons/zap.png') }}" alt="WhatsApp" class="h-8 w-8 md:h-10 md:w-10 object-contain filter brightness-0 saturate-100">
            </button>
            <!-- Ícone do Instagram com link -->
            <a href="https://instagram.com/bistro.terraco?igsh=a3l2ejV3azVyNTBz&utm_sourc" target="_blank" class="bg-none border-none focus:outline-none">
                <img src="{{ asset('Icons/instagram.png') }}" alt="Instagram" class="h-8 w-8 md:h-10 md:w-10 object-contain filter brightness-0 saturate-100">
            </a>
        </div>
    </header>

    <!-- Menu Lateral -->
    <nav id="sideMenu" class="fixed top-0 left-[-260px] w-64 h-full bg-[#B7B7B7] shadow-md transition-all ease-in-out duration-300 pt-5 z-50">
        <!-- Botão para fechar o menu -->
        <button id="closeMenu" class="absolute top-2 right-4 text-2xl text-black bg-none border-none focus:outline-none">
            &times;
        </button>

        <!-- Itens do menu -->
        <ul class="list-none p-0">
            <li class="p-4 border-b border-black-300">
                <a href="{{ route('User.Cardapio') }}" class="text-lg flex items-center gap-2 text-black menu-item hover:text-orange-600 transition-colors">Cardápio</a>
            </li>
            <li class="p-4 border-b border-black-300">
                <a href="{{ route('User.Sacola') }}" class="text-lg flex items-center gap-2 text-black menu-item hover:text-orange-600 transition-colors">Carrinho</a>
            </li>
            <li class="p-4 border-b border-black-300">
                <a href="{{ route('User.VerPedido') }}" class="text-lg flex items-center gap-2 text-black menu-item hover:text-orange-600 transition-colors">Meu Pedido</a>
            </li>
            <li class="p-4 border-b border-black-300">
                <a href="{{ route('User.Localizacao') }}" class="text-lg flex items-center gap-2 text-black menu-item hover:text-orange-600 transition-colors">Localização</a>
            </li>
            <li class="p-4 border-b border-black-300">
                <a href="{{ route('User.Perfil') }}" class="text-lg flex items-center gap-2 text-black menu-item hover:text-orange-600 transition-colors">Perfil</a>
            </li>
        </ul>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuToggle = document.getElementById("menuToggle");
            const sideMenu = document.getElementById("sideMenu");
            const closeMenu = document.getElementById("closeMenu");

            if (menuToggle && sideMenu && closeMenu) {
                // Abrir menu
                menuToggle.addEventListener("click", () => {
                    sideMenu.classList.add("left-0");
                });

                // Fechar menu
                closeMenu.addEventListener("click", () => {
                    sideMenu.classList.remove("left-0");
                });

                // Fechar menu ao clicar fora
                document.addEventListener("click", (event) => {
                    if (!sideMenu.contains(event.target) && !menuToggle.contains(event.target)) {
                        sideMenu.classList.remove("left-0");
                    }
                });
            }
        });
    </script>
</body>

</html>