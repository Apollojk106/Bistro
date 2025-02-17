<div class="h-screen overflow-hidden"> <!-- Contêiner principal com altura da tela e overflow escondido -->
    <x-hotbar-admin />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex h-[calc(100vh-11rem)]"> <!-- Ajuste da altura para considerar a hotbar -->
        <!-- Coluna da esquerda -->
        <div class="flex flex-1 bg-lightblue p-4 overflow-y-auto"> <!-- Adicionado overflow-y-auto -->
            <div class="flex flex-col w-full space-y-4">
                <!-- Formulário de pesquisa -->
                <form action="" class="bg-[#B7B7B7] p-4 rounded-lg w-full flex items-center space-x-2">
                    <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Data</option>
                        <option value="Categoria A">Ano</option>
                        <option value="Categoria B">Mes</option>
                        <option value="Categoria C">Dia</option>
                    </select>

                    <input type="text" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded" />

                    <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain" />
                    </button>
                </form>

                <!-- Grid 2x2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full h-full">
                    <div class="bg-[#B7B7B7] p-4 flex flex-col justify-center items-center">
                        <span class="flex items-center justify-center w-full h-min"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full h-min"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full h-min"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full h-min"> Item 1 : asdasda</span>
                    </div>
                    <div class="bg-[#B7B7B7] p-4 flex flex-col justify-center items-center">
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                    </div>
                    <div class="bg-[#B7B7B7] p-4 flex flex-col justify-center items-center">
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                    </div>
                    <div class="bg-[#B7B7B7] p-4 flex flex-col justify-center items-center">
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full "> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                        <span class="flex items-center justify-center w-full"> Item 1 : asdasda</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna da direita -->
        <div class="fflex flex-1 bg-lightblue p-4 overflow-y-full">
            <div class="flex flex-col w-full space-y-4">
                <!-- Gráfico -->
                <div class="bg-[#B7B7B7] p-4 w-full h-64">
                    <canvas id="graficoPratosVendidos"></canvas>
                </div>

                <script>
                    // Dados passados do controller
                    const pratosVendidos = @json($pratosVendidos);

                    // Configuração do gráfico
                    const ctx = document.getElementById('graficoPratosVendidos').getContext('2d');
                    const graficoPratosVendidos = new Chart(ctx, {
                        type: 'bar', // Tipo de gráfico (barras)
                        data: {
                            labels: Object.keys(pratosVendidos), // Dias da semana
                            datasets: [{
                                label: 'Pratos Vendidos',
                                data: Object.values(pratosVendidos), // Quantidade de pratos vendidos
                                backgroundColor: 'rgba(167, 74, 4, 1)', // Cor de fundo das barras
                                borderColor: 'rgb(0, 0, 0)', // Cor da borda das barras
                                borderWidth: 1 // Largura da borda
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true // Começa o eixo Y a partir de zero
                                }
                            },
                            responsive: true, // Gráfico responsivo
                            maintainAspectRatio: false // Não manter a proporção de aspecto (para ocupar o espaço da div)
                        }
                    });
                </script>

                <!-- Itens -->
                <div class="bg-[#B7B7B7] p-4 w-full h-min">
                    <div class="grid grid-cols-3 gap-4 justify-between w-full h-min">
                        <p class="flex items-center justify-center">Item 1 : asdasda</p>
                        <p class="flex items-center justify-center ">Item 2 : asdasda</p>
                        <p class="flex items-center justify-center ">Item 3 : asdasda</p>
                        <span class="flex items-center justify-center ">Item 4 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 5 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 6 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 4 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 5 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 6 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 4 : asdasda</span>
                        <span class="flex items-center justify-center ">Item 5 : asdasda</span>
                        <span class="flex items-center justify-center ">paia 6 : asdasda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>