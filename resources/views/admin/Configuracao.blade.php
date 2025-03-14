<div>
    <x-hotbar-admin />

    <div class="mt-5 ml-5 mr-5">
        <span class="flex items-center justify-center w-full m-2 mt-5 mb-5">Config</span>

        <form action="{{ route('admin.configuracao.update') }}" method="post">
            @csrf

            @foreach($Configuracoes as $config)
            <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">

            @if($config->type == '1')
            <div class="bg-[#B7B7B7] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-block flex items-center text-center">{{$config->nome}}</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <select name="configs[{{ $config->id }}][status]" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="1" {{ $config->status ? 'selected' : '' }}>Ligado</option>
                            <option value="0" {{ !$config->status ? 'selected' : '' }}>Desligado</option>
                        </select>
                    </div>
                </div>
            </div>
            @elseif($config->type == '2')
            <div class="bg-[#FFFFFF] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-block flex items-center ">{{$config->nome}}</span>
                    </div>
                    <div class="flex items-center justify-center w-min">
                        <input type="text" name="configs[{{ $config->id }}][valores1]" value="{{ $config->valores1 ?? 'erro' }}" class="p-2 outline-none flex-1 border rounded flex items-center justify-center" />
                    </div>
                </div>
            </div>
            @elseif($config->type == '3')
            <div class="bg-[#B7B7B7] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-block flex items-center ">{{$config->nome}}</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <input type="text" name="configs[{{ $config->id }}][valores1]" value="{{ $config->valores1 ?? 'erro' }}" class="p-2 outline-none flex-1 border rounded" />
                        <span class="flex items-center justify-center w-full m-2">As</span>
                        <input type="text" name="configs[{{ $config->id }}][valores2]" value="{{ $config->valores2 ?? 'erro' }}" class="p-2 outline-none flex-1 border rounded" />
                    </div>
                </div>
            </div>
            @endif
            @endforeach

            <div class="flex space-x-4 justify-center mt-2">
                <button type="submit" class="bg-[#B7B7B7] text-black px-6 py-2 rounded-lg flex items-center space-x-2">
                    <span>Aplicar</span> <img src="{{ asset('Icons/check.svg') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                </button>
            </div>
        </form>

        <span class="flex items-center justify-center w-full m-2 mt-5">Formas de Pagamentos</span>

        <table class="min-w-full table-auto text-center table-fixed">
            <thead>
                <tr class="bg-[#B7B7B7] border border-black">
                    <th class="p-2 text-center">Nome</th>
                    <th class="p-2 text-center">Taxa</th>
                    <th class="p-2 text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                <!-- Formulário para todas as ações (adicionar, editar, deletar) -->
                <form action="{{ route('admin.configuracao.forma-pagamento') }}" method="post">
                    @csrf
                    @method('PUT') <!-- Método PUT para atualização -->

                    @foreach($FormaPagamentos as $Form)
                    <tr class="border border-black">
                        <td class="p-2 h-10">
                            <input type="text" name="forma[{{$Form->id}}][nome]" value="{{$Form->nome}}" class="p-2 outline-none flex-1 border rounded h-full" />
                        </td>
                        <td class="p-2 h-10">
                            <input type="text" name="forma[{{$Form->id}}][taxa]" value="{{$Form->taxa}}" class="p-2 outline-none flex-1 border rounded" />
                        </td>
                        <td class="bg-white p-2 rounded-lg flex items-center justify-center h-10">
                            <!-- Botão de editar -->
                            <button type="submit" name="action" value="edit" class="rounded-lg p-2 flex items-center justify-center">
                                <img src="{{ asset('Icons/edit.png') }}" alt="Imagem Centralizada" class="object-contain h-5 w-5" />
                            </button>
                            <!-- Botão de deletar (adiciona o método DELETE) -->
                            <button type="submit" name="action" value="delete{{$Form->id}}" class="rounded-lg p-2 flex items-center justify-center">
                                <img src="{{ asset('Icons/trash.png') }}" alt="Imagem Centralizada" class="object-contain h-5 w-5" />
                            </button>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Linha de adicionar nova forma de pagamento -->
                    <tr class="bg-[#B7B7B7] border border-black">
                        <td class="p-2 h-10">
                            <input type="text" name="forma[new][nome]" value="Cartão" class="p-2 outline-none flex-1 border rounded h-full" />
                        </td>
                        <td class="p-2 h-10">
                            <input type="text" name="forma[new][taxa]" value="2" class="p-2 outline-none flex-1 border rounded h-full" />
                        </td>
                        <td class="p-2 h-10">
                            <button type="submit" name="action" value="add" class="rounded-lg p-2 flex items-center justify-center m-auto">
                                <img src="{{ asset('Icons/plus.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain" />
                            </button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>

        <span class="flex items-center justify-center w-full m-2 mt-5">Estrutura de Recomendados por Categoria</span>
        <span class="flex items-center justify-center w-full m-2 mb-5">Primeira > Segunda > Terceira</span>

        <div class="flex h-auto text-center">
            @foreach($Categorias as $nivel => $categoriasNivel) <!-- Aqui itera sobre 'Primeira', 'Segunda', 'Terceira' -->
            <div class="flex flex-1 flex-col p-4">
                <div class="bg-[#B7B7B7] rounded-lg p-4 w-full h-min mt-1">
                    {{ $nivel }} <!-- Exibe "Primeira", "Segunda", "Terceira" -->
                </div>

                @foreach($categoriasNivel as $categoria) <!-- Itera sobre as categorias dentro de cada nível -->
                <div class="bg-[#B7B7B7] rounded-lg p-4 w-full h-min mt-1">
                    {{ $categoria->nome }} <!-- Exibe o nome da categoria, como "Almoço" -->

                    <!-- Formulário para atualizar a categoria -->
                    <form action="{{ route('admin.configuracao.categoria.update', $categoria->id) }}" method="post">
                        @csrf
                        @method('PUT') <!-- Usar PUT para atualizar -->

                        <div class="flex justify-center items-center space-x-2 mt-1">
                            <!-- Select para escolher o nível da categoria -->
                            <select id="categoria" name="nivel" class="rounded-lg shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Primaria" {{ $categoria->nivel == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                <option value="Secundária" {{ $categoria->nivel == 'Secundária' ? 'selected' : '' }}>Secundária</option>
                                <option value="Terciária" {{ $categoria->nivel == 'Terciária' ? 'selected' : '' }}>Terciária</option>
                            </select>

                            <button type="submit" class="rounded-lg p-2 flex items-center justify-center m-auto">
                                <img src="{{ asset('Icons/edit.png') }}" alt="Ícone" class="h-5 w-5">
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

    </div>

</div>