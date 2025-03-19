<div class="min-h-screen bg-gray-100"> <!-- Fundo mais suave -->
    <x-hotbar-admin />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4">
        <!-- Coluna da esquerda -->
        <div class="flex-1 bg-white p-6 rounded-lg shadow-md overflow-y-auto">
            <div class="flex flex-col w-full space-y-6">
                <!-- Formulário de pesquisa -->
                <form action="{{route('Dashboard.filtro')}}" method="post" class="bg-[#B7B7B7] p-4 rounded-lg w-full flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2">
                    @csrf
                    <select id="filtro" name="filtro" class="shadow appearance-none border rounded w-full md:w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Data">Data</option>
                        <option value="Ano">Ano</option>
                        <option value="Mes">Mes</option>
                        <option value="Dia">Dia</option>
                    </select>

                    <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded w-full md:w-auto" />

                    <button class="bg-white p-2 rounded-lg flex items-center justify-center w-full md:w-auto hover:bg-gray-100 transition duration-300">
                        <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain" />
                    </button>
                </form>

                <!-- Grid 2x2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                    <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm flex flex-col justify-center items-center hover:shadow-md transition duration-300">
                        <span class="text-lg font-semibold text-gray-800">Pedidos</span>
                        <span class="text-gray-700">Total: {{ $pedidosAgendados + $pedidosNormais }}</span>
                        <span class="text-gray-700">Agendados: {{ $pedidosAgendados }}</span>
                        <span class="text-gray-700">Locais: {{ $pedidosNormais }}</span>
                    </div>
                    <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm flex flex-col justify-center items-center hover:shadow-md transition duration-300">
                        <span class="text-lg font-semibold text-gray-800">Valor</span>
                        <span class="text-gray-700">Total: R$ {{ $valorTotalAgendados + $valorTotalNormais }}</span>
                        <span class="text-gray-700">Agendados: R$ {{ $valorTotalAgendados }}</span>
                        <span class="text-gray-700">Locais: R$ {{ $valorTotalNormais }}</span>
                    </div>
                    <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm flex flex-col justify-center items-center hover:shadow-md transition duration-300">
                        <span class="text-lg font-semibold text-gray-800">Categorias Populares</span>
                        @foreach($categoriasMaisPedidas as $item => $quantity)
                        <span class="text-gray-700">
                            {{ $item }} ({{ $quantity }})
                        </span>
                        @endforeach
                    </div>
                    <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm flex flex-col justify-center items-center hover:shadow-md transition duration-300">
                        <span class="text-lg font-semibold text-gray-800">Mais Pedidos</span>
                        @foreach ($itensMaisPedidos as $item)
                        <span class="text-gray-700">
                            {{ $item['item'] }} ({{ $item['total_pedidos'] }})
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna da direita -->
        <div class="flex-1 bg-white p-6 rounded-lg shadow-md overflow-y-auto">
            <div class="flex flex-col w-full space-y-6">
                <!-- Gráfico -->
                <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm">
                    <canvas id="graficoPratosVendidos"></canvas>
                </div>

                <script>
                    // Dados passados do controller
                    const pratosVendidos = @json($pratosVendidos);

                    // Extrai as datas e as quantidades do array
                    const labels = Object.keys(pratosVendidos); // Datas (rótulos)
                    const quantidades = Object.values(pratosVendidos).map(item => item.quantidade); // Quantidades

                    // Configuração do gráfico
                    const ctx = document.getElementById('graficoPratosVendidos').getContext('2d');
                    const graficoPratosVendidos = new Chart(ctx, {
                        type: 'bar', // Tipo de gráfico (barras)
                        data: {
                            labels: labels, // Dias (datas)
                            datasets: [{
                                label: 'Pratos Vendidos',
                                data: quantidades, // Quantidade de pratos vendidos
                                backgroundColor: 'rgba(167, 74, 4, 0.8)', // Cor de fundo das barras
                                borderColor: 'rgba(167, 74, 4, 1)', // Cor da borda das barras
                                borderWidth: 1 // Largura da borda
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true, // Começa o eixo Y a partir de zero
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)', // Cor das linhas de grade
                                    },
                                    ticks: {
                                        color: 'rgba(0, 0, 0, 0.7)', // Cor dos rótulos do eixo Y
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false, // Remove as linhas de grade do eixo X
                                    },
                                    ticks: {
                                        color: 'rgba(0, 0, 0, 0.7)', // Cor dos rótulos do eixo X
                                    }
                                }
                            },
                            responsive: true, // Gráfico responsivo
                            maintainAspectRatio: false, // Não manter a proporção de aspecto
                            plugins: {
                                legend: {
                                    labels: {
                                        color: 'rgba(0, 0, 0, 0.7)', // Cor da legenda
                                    }
                                }
                            }
                        }
                    });
                </script>

                <!-- Itens -->
                <div class="bg-[#B7B7B7] p-6 rounded-lg shadow-sm">
                    <div class="grid grid-cols-3 gap-4 justify-between w-full">
                        <p class="text-lg font-semibold text-gray-800">Dia</p>
                        <p class="text-lg font-semibold text-gray-800">Total</p>
                        <p class="text-lg font-semibold text-gray-800">Valor</p>

                        @foreach ($top3dias as $data => $dados)
                        <span class="text-gray-700">{{ $data }}</span>
                        <span class="text-gray-700">{{ $dados['total_pedidos'] }}</span>
                        <span class="text-gray-700">R$ {{ number_format($dados['valor_total'], 2, ',', '.') }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>