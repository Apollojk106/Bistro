<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Hotbar -->
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto px-5 py-6" x-data="{ showModal: false, pedido: {} }">

        <!-- Barra de pesquisa -->
        <div class="flex items-center justify-center w-full mb-6">
            <form action="{{ route('Historico.filtro') }}" method="post" class="bg-white card-shadow rounded-xl p-4 w-full flex items-center space-x-3">
                @csrf
                <div class="relative flex-1 md:flex-none md:w-48">
                    <select id="categoria" name="categoria" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-300 appearance-none">
                        <option value="id">ID</option>
                        <option value="nome">Nome</option>
                        <option value="valor_total">Valor</option>
                        <option value="updated_at">Data</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative flex-1">
                    <input id="pesquisa" name="pesquisa" type="text" placeholder="Pesquisar..." 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-300">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="submit" class="text-gray-500 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="window.location.href='/admin/Historico'" 
                        class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Tabela de pedidos -->
        <div class="bg-white card-shadow rounded-xl p-6 w-full overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comentários</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($Pedidos as $pedido)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pedido->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $pedido->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($pedido->updated_at)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $pedido->descricao }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="showModal = true; pedido = {{ json_encode($pedido) }}" 
                                    class="text-blue-600 hover:text-blue-800 p-1.5 rounded-full hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pop-up Modal -->
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50 p-4">
            <div @click.away="showModal = false"
                 class="bg-white rounded-xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto"
                 x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <!-- Header -->
                <div class="sticky top-0 bg-white px-6 py-4 border-b flex justify-between items-center rounded-t-xl">
                    <h3 class="text-lg font-semibold text-gray-900">Detalhes do Pedido</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Conteúdo do modal -->
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-800">Nº <span x-text="pedido.id" class="text-blue-600"></span></p>
                        <img src="{{ asset('logo.png') }}" class="mx-auto w-16 h-16 object-contain my-3" alt="Logo">
                        <p class="text-lg font-semibold text-gray-800" x-text="pedido.nome"></p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-700 mb-2">Resumo do Pedido</h4>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-medium">Valor Total:</span> R$ <span x-text="pedido.valor_total"></span></p>
                            <p><span class="font-medium">Tipo:</span> <span x-text="pedido.local ? 'Local' : 'Delivery'" 
                                :class="pedido.local ? 'text-green-600' : 'text-blue-600'"></span></p>
                            <p><span class="font-medium">Status:</span> <span x-text="pedido.status_pedido" 
                                :class="{'text-green-600': pedido.status_pedido === 'Concluído', 
                                         'text-yellow-600': pedido.status_pedido === 'Em andamento',
                                         'text-red-600': pedido.status_pedido === 'Cancelado'}"></span></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Informações do Cliente</h4>
                            <div class="text-sm space-y-1">
                                <p><span class="text-gray-500">Contato:</span> <span x-text="pedido.telefone"></span></p>
                                <p><span class="text-gray-500">Email:</span> <span x-text="pedido.email"></span></p>
                            </div>
                        </div>

                        <div x-show="!pedido.local">
                            <h4 class="font-medium text-gray-700 mb-2">Endereço de Entrega</h4>
                            <div class="text-sm space-y-1">
                                <p><span class="text-gray-500">Bairro:</span> <span x-text="pedido.bairro"></span></p>
                                <p><span class="text-gray-500">Rua:</span> <span x-text="pedido.rua"></span></p>
                                <p><span class="text-gray-500">Número:</span> <span x-text="pedido.numero_residencia"></span></p>
                                <p><span class="text-gray-500">Complemento:</span> <span x-text="pedido.complemento || 'Nenhum'"></span></p>
                            </div>
                        </div>

                        <div x-show="pedido.descricao">
                            <h4 class="font-medium text-gray-700 mb-2">Observações</h4>
                            <p class="text-sm text-gray-600" x-text="pedido.descricao"></p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="sticky bottom-0 bg-white px-6 py-3 border-t flex justify-end rounded-b-xl">
                    <button @click="showModal = false" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                        Fechar
                    </button>
                </div>
            </div>
        </div>

    </div>

</body>

</html>