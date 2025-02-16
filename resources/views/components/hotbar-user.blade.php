<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu e Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-[#B7B7B7] h-40 p-4 flex justify-between items-center relative">
        <!-- Ícone do menu hambúrguer aumentado -->
        <button id="menuToggle" class="text-4xl bg-none border-none">&#9776;</button>
        
        <!-- Logo centralizada -->
        <div class="absolute left-1/2 transform -translate-x-1/2">
            <img src="Logo.png" alt="Logo" class="h-32 object-contain">
        </div>
        
        <!-- Ícones do WhatsApp e Instagram diminuídos -->
        <div class="flex space-x-6">
            <button class="bg-none border-none">
                <img src="{{ asset('Icons/zap.png') }}" alt="WhatsApp" class="h-8 w-8 object-contain">
            </button>
            <button class="bg-none border-none">
                <img src="{{ asset('Icons/instagram.png') }}" alt="Instagram" class="h-8 w-8 object-contain">
            </button>
        </div>
    </header>

    <!-- Menu Lateral -->
    <nav id="sideMenu" class="fixed top-0 left-[-250px] w-64 h-full bg-[#B7B7B7] shadow-md transition-all ease-in-out duration-300 pt-5">
        <button id="closeMenu" class="absolute top-2 right-4 text-2xl bg-none border-none">&times;</button>
        <ul class="list-none p-0">
            <li class="p-4 border-b border-gray-300">
                <a href="#" class="text-lg flex items-center gap-2 menu-item"> Cardápio</a>
            </li>
            <li class="p-4 border-b border-gray-300">
                <a href="#" class="text-lg flex items-center gap-2 menu-item"> Meus Pedidos</a>
            </li>
            <li class="p-4 border-b border-gray-300">
                <a href="#" class="text-lg flex items-center gap-2 menu-item"> Localização</a>
            </li>
            <li class="p-4 border-b border-gray-300">
                <a href="#" class="text-lg flex items-center gap-2 menu-item"> Configuração</a>
            </li>
        </ul>
    </nav>

    

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.getElementById("menuToggle");
            const sideMenu = document.getElementById("sideMenu");
            const closeMenu = document.getElementById("closeMenu");
            const menuItems = document.querySelectorAll(".menu-item");
    
            if (menuToggle && sideMenu && closeMenu) {
                menuToggle.addEventListener("click", () => {
                    sideMenu.classList.add("left-0");
                });
    
                closeMenu.addEventListener("click", () => {
                    sideMenu.classList.remove("left-0");
                });

                menuItems.forEach(item => {
                    item.addEventListener("click", function() {
                        // Remover a classe 'text-orange-600' de todos os itens
                        menuItems.forEach(item => item.classList.remove("text-orange-600"));
                        // Adicionar a classe 'text-orange-600' ao texto do item clicado
                        this.classList.add("text-orange-600");
                    });
                });
            }
        });
    </script>
</body>
</html>