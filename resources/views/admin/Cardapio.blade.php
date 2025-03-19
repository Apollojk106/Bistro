<div>
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto space-y-4 p-5">

        <!-- Barra de pesquisa e botão de atualizar -->
        <div class="flex flex-col md:flex-row items-center justify-between w-full space-y-4 md:space-y-0 md:space-x-4">
            <form action="{{ route('Cardapio.Filtro') }}" method="post" class="bg-[#B7B7B7] p-4 rounded-lg w-full md:w-auto flex-grow flex items-center space-x-2">
                @csrf
                <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="nome">Nome</option>
                    <option value="id_categoria">Categoria</option>
                    <option value="valor">Valor</option>
                </select>

                <input id="conteudo" name="conteudo" type="text" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded" />

                <button type="submit" class="bg-white p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain" />
                </button>
            </form>

            <button type="button" onclick="window.location.href='/admin/Cardapio'" class="bg-[#B7B7B7] p-2 rounded-lg flex items-center justify-center">
                <img src="{{ asset('Icons/refresh.png') }}" alt="Imagem Centralizada" class="h-15 w-15 object-contain h-full" />
            </button>
        </div>

        <!-- Botão "mais" e filtro de categoria -->
        <div class="flex flex-col md:flex-row items-center justify-between w-full space-y-4 md:space-y-0 md:space-x-4">
            <div class="bg-[#B7B7B7] p-4 rounded-lg flex items-center space-x-2 w-full md:w-auto">
                <select id="categoria_eye" name="categoria_eye" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($Categorias as $Categoria)
                    <option value="{{ $Categoria }}">{{ $Categoria }}</option>
                    @endforeach
                </select>

                <!-- Botão "eye-on" -->
                <button id="eye-on" class="p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/eye-on.png') }}" alt="Imagem Centralizada" class="h-15 w-15 object-contain" />
                </button>

                <!-- Botão "eye-off" -->
                <button id="eye-off" class="p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/eye-off.png') }}" alt="Imagem Centralizada" class="h-15 w-15 object-contain" />
                </button>
            </div>

            <a href="{{ route('ItemCardapio') }}" class="w-full md:w-auto">
                <button class="bg-[#B7B7B7] rounded-lg p-2 flex items-center justify-center w-full">
                    <img src="{{ asset('Icons/plus.png') }}" alt="Imagem Centralizada" class="h-full w-full object-contain" />
                </button>
            </a>
        </div>

        <!-- Tabela de itens -->
        <div class="bg-[#B7B7B7] rounded-lg p-4 w-full mt-5 overflow-x-auto">
            <table class="min-w-full table-auto text-center">
                <thead>
                    <tr class="bg-white">
                        <th class="p-2 text-center">Nome</th>
                        <th class="p-2 text-center">Categoria</th>
                        <th class="p-2 text-center">Valor</th>
                        <th class="p-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Items as $Item)
                    <form action="{{ route('EditItemCardapio') }}" method="Post">
                        @csrf
                        <input type="hidden" name="Id" value="{{ $Item->id }}"></input>
                        <tr>
                            <td class="p-2">{{ $Item->nome }}</td>
                            <td class="p-2">{{ $Item->categoria }}</td>
                            <td class="p-2">R$ {{ $Item->valor }}</td>
                            <td class="p-2">
                                <button type="submit" class="bg-green-500 text-white p-1 rounded">
                                    <img src="{{ asset('Icons/edit.png') }}" alt="Imagem Centralizada" class="h-15 w-15 object-contain" />
                                </button>
                                <button type="button" class="bg-red-400 text-white p-1 rounded delete-button" data-id="{{ $Item->id }}">
                                    <img src="{{ asset('Icons/trash.png') }}" alt="Ícone Lixeira" class="h-10 w-10 object-contain" />
                                </button>
                            </td>
                        </tr>
                    </form>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Adicionar eventos de clique aos botões
        document.getElementById('eye-on').addEventListener('click', function() {
            const categoria = document.getElementById('categoria_eye').value;
            window.location.href = `/eye-on?categoria=${categoria}`;
        });

        document.getElementById('eye-off').addEventListener('click', function() {
            const categoria = document.getElementById('categoria_eye').value;
            window.location.href = `/eye-off?categoria=${categoria}`;
        });

        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                if (confirm("Você tem certeza que deseja deletar?")) {
                    window.location.href = `/admin/Cardapio/Delete${itemId}`;
                }
            });
        });
    </script>
</div>