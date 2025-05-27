<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <x-hotbar-admin />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>

    <div class="container mx-auto p-4 lg:p-6">
      

        <!-- Two Column Layout -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column -->
            <div class="flex-1">
                <!-- Search Form -->
                <form action="{{route('Dashboard.filtro')}}" method="post" class="bg-white p-4 rounded-xl shadow-md mb-6 transition-all duration-300 hover:shadow-lg">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <select id="filtro" name="filtro" class="appearance-none bg-gray-50 border-0 rounded-lg py-2 pl-10 pr-8 w-full text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="Data">Data</option>
                                <option value="Ano">Ano</option>
                                <option value="Mes">Mês</option>
                                <option value="Dia">Dia</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar..." class="flex-1 bg-gray-50 border-0 rounded-lg py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200" />
                        
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg flex items-center justify-center transition duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Pedidos Card -->
                    <div class="bg-white p-6 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Pedidos</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-medium text-gray-800">{{ $pedidosAgendados + $pedidosNormais }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Agendados:</span>
                                <span class="font-medium text-blue-600">{{ $pedidosAgendados }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Locais:</span>
                                <span class="font-medium text-green-600">{{ $pedidosNormais }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Valor Card -->
                    <div class="bg-white p-6 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Valor</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-medium text-gray-800">R$ {{ number_format($valorTotalAgendados + $valorTotalNormais, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Agendados:</span>
                                <span class="font-medium text-blue-600">R$ {{ number_format($valorTotalAgendados, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Locais:</span>
                                <span class="font-medium text-green-600">R$ {{ number_format($valorTotalNormais, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Categorias Card -->
                    <div class="bg-white p-6 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Categorias Populares</h3>
                        </div>
                        <div class="space-y-2">
                            @foreach($categoriasMaisPedidas as $item => $quantity)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 truncate">{{ $item }}</span>
                                <span class="font-medium text-purple-600">{{ $quantity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mais Pedidos Card -->
                    <div class="bg-white p-6 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Mais Pedidos</h3>
                        </div>
                        <div class="space-y-2">
                            @foreach ($itensMaisPedidos as $item)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 truncate">{{ $item['item'] }}</span>
                                <span class="font-medium text-orange-600">{{ $item['total_pedidos'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex-1">
                <!-- Chart -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-6 transition-all duration-300 hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pratos Vendidos</h3>
                    <div class="h-64">
                        <canvas id="graficoPratosVendidos"></canvas>
                    </div>
                </div>

                <script>
                    // Animation for chart rendering
                    document.addEventListener('DOMContentLoaded', function() {
                        // Dados passados do controller
                        const pratosVendidos = @json($pratosVendidos);

                        // Extrai as datas e as quantidades do array
                        const labels = Object.keys(pratosVendidos); // Datas (rótulos)
                        const quantidades = Object.values(pratosVendidos).map(item => item.quantidade); // Quantidades

                        // Configuração do gráfico
                        const ctx = document.getElementById('graficoPratosVendidos').getContext('2d');
                        const graficoPratosVendidos = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Pratos Vendidos',
                                    data: quantidades,
                                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                                    borderColor: 'rgba(79, 70, 229, 1)',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                    hoverBackgroundColor: 'rgba(99, 102, 241, 0.9)'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        ticks: {
                                            color: 'rgba(0, 0, 0, 0.6)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: 'rgba(0, 0, 0, 0.6)'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: 'rgba(0, 0, 0, 0.7)',
                                            font: {
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                        bodyFont: {
                                            size: 12
                                        },
                                        padding: 12,
                                        cornerRadius: 6
                                    }
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeOutQuart'
                                }
                            }
                        });

                        // Add animation to chart bars
                        anime({
                            targets: graficoPratosVendidos.data.datasets[0],
                            data: quantidades,
                            duration: 1500,
                            easing: 'easeOutElastic(1, .8)',
                            delay: anime.stagger(100),
                            round: 1,
                            update: function(anim) {
                                graficoPratosVendidos.update();
                            }
                        });
                    });
                </script>

                <!-- Top Days -->
                <div class="bg-white p-6 rounded-xl shadow-md transition-all duration-300 hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Dias</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dia</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($top3dias as $data => $dados)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $data }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $dados['total_pedidos'] }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-green-600">R$ {{ number_format($dados['valor_total'], 2, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Apply animations to cards */
    .bg-white {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }

    /* Delay animations for each card */
    .bg-white:nth-child(1) { animation-delay: 0.1s; }
    .bg-white:nth-child(2) { animation-delay: 0.2s; }
    .bg-white:nth-child(3) { animation-delay: 0.3s; }
    .bg-white:nth-child(4) { animation-delay: 0.4s; }

    /* Smooth scroll for tables */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }
</style>

<script>
    // Add hover effect to table rows
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                anime({
                    targets: row,
                    translateX: 5,
                    duration: 200,
                    easing: 'easeOutQuad'
                });
            });
            
            row.addEventListener('mouseleave', () => {
                anime({
                    targets: row,
                    translateX: 0,
                    duration: 200,
                    easing: 'easeOutQuad'
                });
            });
        });
    });
</script>