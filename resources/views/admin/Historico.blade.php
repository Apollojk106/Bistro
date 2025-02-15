<div>
    <x-hotbar-admin />

    <div class="flex flex-col w-full h-auto space-y-4">

        <div class="flex items-center justify-center w-auto space-x-3 mt-5 mr-5 ml-5">
            <form action="" class="bg-[#B7B7B7] p-4 rounded-lg w-full h-auto flex items-center space-x-2 m-auto">
                <div class="flex items-center space-x-2">
                    <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Nome</option>
                        <option value="Categoria A">Categoria</option>
                        <option value="Categoria B">Valor</option>
                        <option value="Categoria C">Data</option>
                    </select>
                    <img src="{{ asset('Icons/vector.png') }}" alt="Ícone" class="h-5 w-10">
                </div>

                <input type="text" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded" />

                <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain" />
                </button>
            </form>
        </div>


        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto mt-5 ml-5 mr-5 flex justify-center overflow-x-auto">
            <table class="min-w-full table-auto text-center">
                <thead>
                    <tr class="bg-white">
                        <th class="p-2 text-center">Nome</th>
                        <th class="p-2 text-center">Categoria</th>
                        <th class="p-2 text-center">Categoria</th>
                        <th class="p-2 text-center">Categoria</th>
                        <th class="p-2 text-center">Valor</th>
                        <th class="p-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2">Produto 1</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">R$ 100,00</td>
                        <td class="p-2">
                            <button class="text-white p-1 rounded">
                                <img src="{{ asset('Icons/maximize.png') }}" alt="Imagem Centralizada" class="object-contain" />
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2">Produto 1</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">Categoria A</td>
                        <td class="p-2">R$ 100,00</td>
                        <td class="p-2">
                            <button class="text-white p-1 rounded">
                                <img src="{{ asset('Icons/maximize.png') }}" alt="Imagem Centralizada" class="object-contain" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>