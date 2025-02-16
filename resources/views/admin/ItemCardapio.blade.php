<div class="min-h-screen">
    <x-hotbar-admin />

    <div class="flex flex-col md:flex-row h-[calc(100vh-13rem)] flex-1 m-5">
        <!-- Coluna 1 -->
        <div class="flex-1 bg-blue-200 p-4 m-2 justify-between">
            <div class="flex flex-col items-center justify-center p-4 m-2 bg-white rounded-lg shadow">
                <label for="imagem" class="text-lg font-semibold mb-2">Carregar Imagem</label>
                <input type="file" id="imagem" accept="image/*" class="w-full p-2 border rounded">
            </div>

            <!-- Descrição -->
            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Descrição</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>
        </div>

        <!-- Coluna 2 -->
        <div class="flex-1 bg-green-200 p-4 m-2">
            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Nome do Item</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>

            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Valor</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>

            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Categoria</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>

            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Igredientes</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>
        </div>

        <!-- Coluna 3 -->
        <div class="flex-1 bg-red-200 p-4 m-2">
            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Desconto</label>
                <input type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
            </div>

            <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                <label for="imagem" class="text-lg font-semibold mb-2">Disponibilidade</label>
                <select id="categoria" name="categoria" class="w-full shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Nome</option>
                    <option value="Categoria A">Categoria</option>
                    <option value="Categoria B">Valor</option>
                    <option value="Categoria C">Data</option>
                </select>
            </div>

            <div class="text-center p-4 rounded-lg m-2">
                <div class="flex justify-center space-x-4"> <!-- Container flexível com espaçamento entre os botões -->
                    <!-- Botão Salvar -->
                    <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('Icons/save.png') }}" alt="Ícone Salvar" class="h-12 w-12 object-contain" />
                    </button>

                    <!-- Botão Lixeira -->
                    <button class="bg-white p-2 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('Icons/trash.png') }}" alt="Ícone Lixeira" class="h-12 w-12 object-contain" />
                    </button>
                </div>
            </div>


        </div>
    </div>
</div>