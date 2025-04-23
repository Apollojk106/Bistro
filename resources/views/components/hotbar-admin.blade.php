<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div>  
    <x-sweet-alert />

    <!-- Logo -->
    <div class="w-full bg-[#B7B7B7] flex justify-center items-center shadow-lg py-4">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-20 w-auto object-contain md:h-28">
    </div>

    <!-- Hotbar de Navegação -->
    <div class="w-full bg-[#2E2E2E] shadow-lg">
        <div class="container mx-auto px-2 sm:px-4 lg:px-8">
            <div class="flex flex-wrap justify-center md:justify-between items-center gap-1 sm:gap-2 py-2">
                <!-- Item Pedidos -->
                <a href="{{ route('Pedidos') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/clipboard.png') }}" alt="Pedidos" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Pedidos</span>
                </a>
                
                <!-- Item Dashboard -->
                <a href="{{ route('Dashboard') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/table.png') }}" alt="Dashboard" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Dashboard</span>
                </a>
                
                <!-- Item Cardápio -->
                <a href="{{ route('Cardapio') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/edit.png') }}" alt="Cardápio" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Cardápio</span>
                </a>
                
                <!-- Item Histórico -->
                <a href="{{ route('Historico') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/book.png') }}" alt="Histórico" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Histórico</span>
                </a>
                
                <!-- Item Configuração -->
                <a href="{{ route('Configuracao') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/cog.png') }}" alt="Configuração" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Config</span>
                </a>
                
                <!-- Item Pessoas -->
                <a href="{{ route('Pessoas') }}" class="flex flex-col items-center p-1 sm:p-2 cursor-pointer text-[#B7B7B7] hover:text-white transition-colors min-w-[60px]">
                    <img src="{{ asset('Icons/Person.png') }}" alt="Pessoas" class="h-6 w-6 sm:h-8 sm:w-8 object-contain">
                    <span class="text-xs sm:text-sm mt-1">Pessoas</span>
                </a>
            </div>
        </div>
    </div>
</div>