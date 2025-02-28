<div>
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto space-y-4">

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
                    <img src="{{ asset('Icons/refresh.png') }}" alt="Imagem Centralizada" class="object-contain  h-full" />
                </button>
            </form>

        </div>


        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto mt-5 ml-5 mr-5 flex justify-center overflow-x-auto">
            <table class="min-w-full table-auto text-center">
                <thead>
                    <tr class="bg-white">
                        <th class="p-2 text-center">ID</th>
                        <th class="p-2 text-center">Nome</th>
                        <th class="p-2 text-center">Valor</th>
                        <th class="p-2 text-center">Data de Conclução</th>
                        <th class="p-2 text-center">Comentarios</th>
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
                            <button class="text-white p-1 rounded">
                                <img src="{{ asset('Icons/maximize.png') }}" alt="Imagem Centralizada" class="object-contain" />
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>