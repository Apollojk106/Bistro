<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            max-width: 100vw;
            overflow-x: hidden;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-white text-black w-full max-w-screen overflow-x-hidden">
    <x-sweet-alert />

    <!-- Logo -->
    <div class="w-full bg-[#B7B7B7] flex justify-center items-center shadow-lg py-4">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-20 w-auto object-contain md:h-28">
    </div>

    <!-- Hotbar de Navegação -->
    <nav class="w-full bg-[#2E2E2E] shadow-lg">
        <div class="max-w-full overflow-x-auto scrollbar-hide">
            <div class="flex justify-center items-center gap-4 px-2 sm:px-4 py-2 min-w-fit">

                <!-- Item Pedidos -->
                <a href="{{ route('Pedidos') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Pedidos') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/clipboard.png') }}" alt="Pedidos" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Pedidos') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Pedidos</span>
                </a>

                <!-- Item Dashboard -->
                <a href="{{ route('Dashboard') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Dashboard') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/table.png') }}" alt="Dashboard" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Dashboard') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Dashboard</span>
                </a>

                <!-- Item Cardápio -->
                <a href="{{ route('Cardapio') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Cardapio') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/edit.png') }}" alt="Cardápio" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Cardapio') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Cardápio</span>
                </a>

                <!-- Item Histórico -->
                <a href="{{ route('Historico') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Historico') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/book.png') }}" alt="Histórico" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Historico') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Histórico</span>
                </a>

                <!-- Item Configuração -->
                <a href="{{ route('Configuracao') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Configuracao') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/cog.png') }}" alt="Configuração" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Configuracao') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Config</span>
                </a>

                <!-- Item Pessoas -->
                <a href="{{ route('Pessoas') }}" class="flex flex-col items-center min-w-[60px] {{ request()->routeIs('Pessoas') ? 'text-orange-500' : 'text-white' }}">
                    <img src="{{ asset('Icons/Person.png') }}" alt="Pessoas" class="h-6 w-6 sm:h-8 sm:w-8 object-contain {{ request()->routeIs('Pessoas') ? 'filter brightness-125' : '' }}">
                    <span class="text-xs sm:text-sm mt-1">Pessoas</span>
                </a>

            </div>
        </div>
    </nav>
</body>
