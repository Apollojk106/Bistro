<div>
    <x-hotbar-admin />



    <div class="mt-5 ml-5 mr-5">
        <span class="flex items-center justify-center w-full m-2 mt-5 mb-5">Config</span>

        <form action="" method="post">

            <div class="bg-[#B7B7B7] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-block flex items-center text-center">Config</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Ligado</option>
                            <option value="Categoria A">Desligado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-[#FFFFFF] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-block flex items-center ">Tempo minimo de Agendamento</span>
                    </div>
                    <div class="flex items-center justify-center w-min">
                        <input type="text" value="15:00" class="p-2 outline-none flex-1 border rounded flex items-center justify-center" />
                    </div>
                </div>
            </div>

            <div class="bg-[#B7B7B7] border border-black rounded-lg p-4 w-auto flex justify-center overflow-x-auto">
                <div class="min-w-full grid grid-cols-2 gap-4">
                    <div class="flex items-center justify-center">
                    <span class="inline-block flex items-center ">Horario de Funcionamento </span>
                    </div>
                    <div class="flex items-center justify-center">
                        <input type="text" value="9:00" class="p-2 outline-none flex-1 border rounded" />
                        <span class="flex items-center justify-center w-full m-2">As</span>
                        <input type="text" value="20:00" class="p-2 outline-none flex-1 border rounded" />
                    </div>
                </div>
            </div>

            <div class="flex space-x-4 justify-center mt-2">
                <button class="bg-[#B7B7B7] text-black px-6 py-2 rounded-lg flex items-center space-x-2">
                    <span>Aplicar</span> <img src="{{ asset('Icons/check.svg') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                </button>
            </div>

        </form>

        <span class="flex items-center justify-center w-full m-2 mt-5 ">Formas de Pagamentos</span>

        <table class="min-w-full table-auto text-center table-fixed">
            <thead>
                <tr class="bg-[#B7B7B7] border border-black ">
                    <th class="p-2 text-center ">Nome</th>
                    <th class="p-2 text-center">Taxa</th>
                    <th class="p-2 text-center ">Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border border-black">
                    <td class="p-2 h-10">Pix</td>
                    <td class="p-2 h-10">
                        <input type="text" value="0" class="p-2 outline-none flex-1 border rounded" />
                    </td>
                    <td class="bg-white p-2 rounded-lg flex items-center justify-center h-10">
                        <button class="rounded-lg p-2 flex items-center justify-center">
                            <img src="{{ asset('Icons/edit.png') }}" alt="Imagem Centralizada" class="object-contain h-5 w-5" />
                        </button>
                        <button class="rounded-lg p-2 flex items-center justify-center">
                            <img src="{{ asset('Icons/trash.png') }}" alt="Imagem Centralizada" class="object-contain h-5 w-5" />
                        </button>
                    </td>
                </tr>
                <tr class="bg-[#B7B7B7] border border-black">
                    <td class="p-2 h-10 ">
                        <input type="text" value="Cartão" class="p-2 outline-none flex-1 border rounded h-full" />
                    </td>
                    <td class="p-2 h-10">
                        <input type="text" value="2" class="p-2 outline-none flex-1 border rounded h-full" />
                    </td>
                    <td class="p-2 h-10 ">
                        <button class="rounded-lg p-2 flex items-center justify-center m-auto">
                            <img src="{{ asset('Icons/plus.png') }}" alt="Imagem Centralizada" class="h-10 w-10 object-contain" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <span class="flex items-center justify-center w-full m-2 mt-5 ">Estrutura de Recomendados por Categoria</span>
        <span class="flex items-center justify-center w-full m-2 mb-5 ">Primeira > Segunda > Terceira</span>

        <div class="flex h-auto text-center">
            <div class="flex flex-1 flex-col p-4">
                <div class="bg-[#B7B7B7]  rounded-lg p-4 w-full h-min mt-1">
                    Primeira
                </div>

                <div class="bg-[#B7B7B7] rounded-lg p-4 w-full h-min mt-1">
                    Almoço

                    <form action="">
                        <div class="flex justify-center items-center space-x-2 mt-1">
                            <select id="categoria" name="categoria" class="rounded-lg shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Primeira</option>
                                <option value="">Secundaria</option>
                                <option value="">Terciaria</option>
                            </select>
                            <button class="rounded-lg p-2 flex items-center justify-center m-auto">
                                <img src="{{ asset('Icons/edit.png') }}" alt="Ícone" class="h-5 w-5">
                            </button>
                            

                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-1 flex-col p-4">
                <div class="bg-[#B7B7B7]  rounded-lg p-4 w-full h-min mt-1">
                    Segunda
                </div>
            </div>

            <div class="flex flex-1 flex-col p-4">
                <div class="bg-[#B7B7B7] rounded-lg p-4 w-full h-min mt-1">
                    Terceira
                </div>
            </div>
        </div>
    </div>

</div>