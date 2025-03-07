<div>
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto space-y-4">

        <div class="flex items-center justify-center w-auto space-x-3 mt-5 mr-5 ml-5">
            <form action="{{ route('Cardapio.Filtro') }}" method="post" class="bg-[#B7B7B7] p-4 rounded-lg w-full h-auto flex items-center space-x-2 m-auto">
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

            <button type="button" onclick="window.location.href='/admin/Cardapio'" class="bg-[#B7B7B7]  p-2 rounded-lg flex items-center justify-center">
                <img src="{{ asset('Icons/refresh.png') }}" alt="Imagem Centralizada" class="h-15 w-15 object-contain h-full" />
            </button>

            <div class="bg-[#B7B7B7] p-4 rounded-lg flex items-center space-x-2 h-auto">
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

            <a href="{{ route('ItemCardapio') }}">
                <button class="bg-[#B7B7B7] rounded-lg p-2 flex items-center justify-center m-auto">
                    <img src="{{ asset('Icons/plus.png') }}" alt="Imagem Centralizada" class="h-full w-full object-contain" />
                </button>
            </a>
        </div>


        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto mt-5 ml-5 mr-5 flex justify-center overflow-x-auto">
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
                                <button type="button" class="bg-red-500 text-white p-1 rounded ml-2">
                                    <img src="{{ asset('Icons/trash.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain" />
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
            // Pega o valor da categoria selecionada
            const categoria = document.getElementById('categoria_eye').value;

            // Redireciona para a rota "eye-on" passando o valor da categoria como parâmetro
            window.location.href = `/eye-on?categoria=${categoria}`;
        });

        document.getElementById('eye-off').addEventListener('click', function() {
            // Pega o valor da categoria selecionada
            const categoria = document.getElementById('categoria_eye').value;

            // Redireciona para a rota "eye-off" passando o valor da categoria como parâmetro
            window.location.href = `/eye-off?categoria=${categoria}`;
        });
    </script>
</div>