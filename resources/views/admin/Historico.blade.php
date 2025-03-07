<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script> 
</head>

<body class="bg-gray-100">

    <!-- Hotbar -->
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto space-y-4" x-data="{ showModal: false, pedido: {} }">

        <!-- Barra de pesquisa -->
        <div class="flex items-center justify-center w-auto space-x-3 mt-5 mr-5 ml-5">
            <form action="{{ route('Historico.filtro') }}" method="post" class="bg-[#B7B7B7] p-4 rounded-lg w-full h-auto flex items-center space-x-2 m-auto">
                @csrf
                <div class="flex items-center space-x-2">
                    <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="id">ID</option>
                        <option value="nome">Nome</option>
                        <option value="valor_total">Valor</option>
                        <option value="updated_at">Data</option>
                    </select>
                </div>

                <input id="pesquisa" name="pesquisa" type="text" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded" />

                <button type="submit" class="bg-white p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain h-full" />
                </button>

                <button type="button" onclick="window.location.href='/admin/Historico'" class="bg-white p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/refresh.png') }}" alt="Imagem Centralizada" class="object-contain h-full" />
                </button>
            </form>
        </div>

        <!-- Tabela de pedidos -->
        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto mt-5 ml-5 mr-5 flex justify-center overflow-x-auto">
            <table class="min-w-full table-auto text-center">
                <thead>
                    <tr class="bg-white">
                        <th class="p-2 text-center">ID</th>
                        <th class="p-2 text-center">Nome</th>
                        <th class="p-2 text-center">Valor</th>
                        <th class="p-2 text-center">Data de Conclusão</th>
                        <th class="p-2 text-center">Comentários</th>
                        <th class="p-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Pedidos as $pedido)
                    <tr>
                        <td class="p-2">{{ $pedido->id }}</td>
                        <td class="p-2">{{ $pedido->nome }}</td>
                        <td class="p-2">R$ {{ $pedido->valor_total }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($pedido->updated_at)->format('d/m/Y') }}</td>
                        <td class="p-2">{{ $pedido->descricao }}</td>
                        <td class="p-2">
                            <!-- Botão para abrir o modal -->
                            <button @click="showModal = true; pedido = {{ json_encode($pedido) }}" class="text-white p-1 rounded">
                                <img src="{{ asset('Icons/maximize.png') }}" alt="Imagem Centralizada" class="object-contain" />
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pop-up Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-5 rounded-lg shadow-lg w-96 relative">
                <!-- Botão para fechar o modal -->
                <button @click="showModal = false" class="absolute top-2 right-2 text-black text-lg">&times;</button>

                <!-- Conteúdo do modal -->
                <div class="text-center">
                    <p class="text-lg font-bold">Nº <span x-text="pedido.id"></span></p>
                    <img src="{{ asset('logo.png') }}" class="mx-auto w-16" alt="Logo">
                    <p class="mt-2 font-semibold" x-text="pedido.nome"></p>

                    <p class="mt-2"><span x-text="pedido.Items"></span></p>

                    <p class="mt-3 font-semibold text-xl" x-text="'R$ ' + pedido.valor_total"></p>

                    <p class="mt-2 font-bold text-green-600" x-text="pedido.local ? 'Local' : 'Delivery'"></p>
                    <p class="mt-2">Categoria Pedido: <span x-text="pedido.categoria_pedido"></span></p>
                    <p class="mt-2">Status Pagamento: <span x-text="pedido.status_pedido"></span></p>
                    <p class="mt-2">Opção de Entrega: <span x-text="pedido.opcao_entrega"></span></p>
                    <p class="mt-2">Forma de Pagamento: <span x-text="pedido.id_forma_pagamento"></span></p>
                    <p class="mt-2">Descrição: <span x-text="pedido.descricao"></span></p>

                    <p class="mt-2">Contato: <span x-text="pedido.telefone"></span></p>
                    <p class="mt-2">Email: <span x-text="pedido.email"></span></p>
                    <p class="mt-2">Bairro: <span x-text="pedido.bairro"></span></p>
                    <p class="mt-2">Rua: <span x-text="pedido.rua"> </span></p>
                    <p class="mt-2">Número Residência: <span x-text="pedido.numero_residencia"></span></p>
                    <p class="mt-2">Complemento: <span x-text="pedido.complemento"></span></p>


                </div>

            </div>
        </div>

    </div>

</body>

</html>