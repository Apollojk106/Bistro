<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div>  
   <!-- Imagem Centralizada com Tamanho Fixo -->
    <div class="w-full h-32 bg-[#B7B7B7] flex justify-center items-center shadow-lg">
        <img src="{{ asset('Logo.png') }}" alt="Imagem Centralizada" class="h-200 w-200 object-contain">
    </div>

    <!-- Seção com Padding e Itens Responsivos -->
    <div class="w-full h-auto bg-[#2E2E2E] flex justify-between items-center shadow-lg" style="padding-left: 10%; padding-right: 10%;">
        <a href="{{ route('Pedidos') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/clipboard.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Pedidos</p> <!-- Texto escondido em telas pequenas -->
        </a>
        <a href="{{ route('Dashboard') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/table.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Dashboard</p> <!-- Texto escondido em telas pequenas -->
        </a>
        <a href="{{ route('Cardapio') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/edit.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Editar Cardapio</p> <!-- Texto escondido em telas pequenas -->
        </a>
        <a href="{{ route('Historico') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/book.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Histórico</p> <!-- Texto escondido em telas pequenas -->
        </a>
        <a href="{{ route('Configuracao') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/cog.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Configuração</p> <!-- Texto escondido em telas pequenas -->
        </a>

        <a href="{{ route('Pessoas') }}" class="flex items-center m-1 cursor-pointer" style="color: B7B7B7;">
            <img src="{{ asset('Icons/Person.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p class="hidden sm:block">Pessoas</p> <!-- Texto escondido em telas pequenas -->
        </a>

    </div>
</div>