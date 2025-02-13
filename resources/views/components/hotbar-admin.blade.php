<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div>
    
   <!-- Imagem Centralizada com Tamanho Fixo -->
    <div class="w-full h-32 bg-[#B7B7B7] flex justify-center items-center shadow-lg">
        <img src="{{ asset('Logo.png') }}" alt="Imagem Centralizada" class="h-100 w-100 object-contain">
    </div>

<!-- Seção com Padding e Itens Responsivos -->
    <div class="w-full h-auto bg-[#2E2E2E] flex justify-between items-center shadow-lg" style="padding-left: 10%; padding-right: 10%;">
        <div class="flex items-center m-1" style="color: A74A04;" >
            <img src="{{ asset('Icons/clipboard.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain">
            <p>Pedidos</p>
        </div>
        <div class="flex-1 text-center">
            <p style="color: blue;">Dashboard</p>
        </div>
        <div class="flex-1 text-center">
            <p style="color: blue;">Editar Cardapio</p>
        </div>
        <div class="flex-1 text-center">
            <p style="color: blue;">Históico</p>
        </div>
        <div class="flex-1 text-center">
            <p style="color: blue;">Configuração</p>
        </div>
    </div>

</div>

