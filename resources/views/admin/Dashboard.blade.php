<div>
    <x-hotbar-admin />

    <div class="flex h-auto">
        <div class="flex flex-1 bg-lightblue p-4 h-auto">
            <!-- Barra de pesquisa -->
            <div class="flex flex-col w-full h-full space-y-4">
                <!-- Barra de pesquisa -->
                <form action="" class="bg-[#B7B7B7] p-4 rounded-lg w-full h-auto flex items-center space-x-2 m-auto">
                    <select id="categoria" name="categoria" class="shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Data</option>
                        <option value="Categoria A">Ano</option>
                        <option value="Categoria B">Mes</option>
                        <option value="Categoria C">Dia</option>
                    </select>

                    <input type="text" placeholder="Pesquisar..." class="p-2 outline-none flex-1 border rounded" />

                    <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('Icons/search.png') }}" alt="Imagem Centralizada" class="object-contain" />
                    </button>
                </form>

                <!-- Grid de Itens -->
                <div class="grid grid-cols-2 gap-4 w-full h-auto">
                    <div class="bg-blue-200 p-4">Item 1</div>
                    <div class="bg-blue-200 p-4">Item 2</div>
                    <div class="bg-blue-200 p-4">Item 3</div>
                    <div class="bg-blue-200 p-4">Item 4</div>

                </div>
            </div>

        </div>

        <div class="flex flex-1 bg-lightcoral p-4 h-auto">
            <!-- Conteúdo da parte direita -->
            <div class="flex flex-col w-full h-full space-y-4">
                <div class="bg-blue-200 p-4 w-full">
                    Grafico
                </div>

                <div class="bg-blue-200 p-4 w-full">
                    Itens
                </div>


            </div>
        </div>
    </div>