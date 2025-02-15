<div>
    <x-hotbar-admin />



    <div class=" mt-5 ml-5 mr-5 ">
        <span class="flex items-center justify-center w-full m-2">Config</span>

        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
            <div class="min-w-full table-auto text-center flex  justify-between">
                <span class="inline-block flex items-center ">Config</span>
                <div class="flex items-center space-x-2">
                    <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Ligado</option>
                        <option value="Categoria A">Desligado</option>
                    </select>
                    <img src="{{ asset('Icons/vector.png') }}" alt="Ícone" class="h-5 w-10">
                </div>
            </div>
        </div>

        <div class="bg-[#C9C9C9] rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
            <div class="min-w-full table-auto text-center flex justify-between">
                <span class="inline-block flex items-center ">Tempo minimo de Agendamento</span>
                <div class="flex w-min items-center">
                    <input type="text" value="15:00" class="p-2 outline-none flex-1 border rounded" />
                </div>
            </div>
        </div>

        <div class="bg-[#B7B7B7] rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
            <div class="min-w-full table-auto text-center flex justify-between">
                <span class="inline-block flex items-center ">Horario de Funcionamento </span>
                <div class="flex w-min items-center">
                    <input type="text" value="9:00" class="p-2 outline-none flex-1 border rounded" />

                    <span class="flex items-center justify-center w-full m-2">As</span>

                    <input type="text" value="20:00" class="p-2 outline-none flex-1 border rounded" />
                </div>
            </div>
        </div>

        <span class="flex items-center justify-center w-full m-2">Formas de Pagamentos</span>

        <thead>
            <tr class="bg-white">
                <th class="p-2 text-center">Nome</th>
                <th class="p-2 text-center">Taxa</th>
                <th class="p-2 text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2">Pix</td>
                <td class="p-2">0</td>
                <td class="p-2">
                    <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('Icons/edit.png') }}" alt="Imagem Centralizada" class="object-contain" />
                    </button>
                </td>
            </tr>

            <tr>
                <td class="p-2">Pix</td>
                <td class="p-2">0</td>
                <td class="p-2">Categoria A</td>
            </tr>
        </tbody>

        <span class="flex items-center justify-center w-full m-2">Estrutura de Recomendados por Categoria</span>
        <span class="flex items-center justify-center w-full m-2">Primeira > Segunda > Terceira</span>


    </div>


</div>