<div class="min-h-screen">
    <x-hotbar-admin />

    <form action="{{ route('SaveItem') }}" method="post">
        @csrf
        <div class="flex flex-col md:flex-row h-[calc(100vh-13rem)] flex-1 m-5 bg-[#B7B7B7]">


            <!-- Coluna 1 -->
            <div class="flex-1 p-4 m-2 justify-between">
                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Nome do Item</label>
                    <input id="Nome" name="Nome" type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex flex-col items-center justify-center p-4 m-2 bg-white rounded-lg shadow">
                    <label for="imagem" class="text-lg font-semibold mb-2">Carregar Imagem</label>
                    <input id="Imagem" name="Imagem" type="file" id="imagem" accept="image/*" class="w-full p-2 border rounded">
                </div>

                <!-- Descrição -->
                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Descrição</label>
                    <input id="Descricao" name="Descricao" type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>
            </div>

            <!-- Coluna 2 -->
            <div class="flex-1 p-4 m-2">


                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Valor</label>
                    <input id="Valor" name="Valor" type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>

                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="categoria" class="text-lg font-semibold mb-2">Categoria</label>

                    <!-- Select para categorias existentes e a opção de adicionar nova categoria -->
                    <select id="categoria" name="categoria" class="w-full shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="handleCategoryChange(this)">
                        <option value="">Escolha uma Categoria</option>

                        <!-- Preenchendo com as categorias existentes -->
                        @foreach($Categorias as $id => $nome)
                        <option value="{{ $id }}">{{ $nome }}</option>
                        @endforeach

                        <!-- Opção para adicionar nova categoria -->
                        <option value="novo">Adicionar Nova Categoria</option>
                    </select>

                    <!-- Input para nova categoria (será exibido quando a opção "Adicionar Nova Categoria" for selecionada) -->
                    <div id="newcategory-container" style="display: none;">
                        <label for="newcategory" class="text-lg font-semibold mt-2">Nova Categoria</label>
                        <input type="text" id="newcategory" name="newcategory" class="w-full shadow appearance-none border rounded w-auto py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o nome da nova categoria">
                    </div>
                </div>

                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Igredientes</label>
                    <input id="Igredientes" name="Igredientes" type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>
            </div>

            <!-- Coluna 3 -->
            <div class="flex-1 p-4 m-2">
                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Desconto</label>
                    <input id="Desconto" name="Desconto" type="text" value="" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>

                <div class="text-center bg-white p-4 rounded-lg shadow m-2">
                    <label for="imagem" class="text-lg font-semibold mb-2">Disponibilidade</label>
                    <input id="Disponibilidade" name="Disponibilidade" type="text" value="Todo dia" class="border border-gray-300 p-2 rounded-lg w-full" placeholder="Digite algo aqui...">
                </div>

                <div class="text-center p-4 rounded-lg m-2">
                    <div class="flex justify-center space-x-4"> <!-- Container flexível com espaçamento entre os botões -->
                        <!-- Botão Salvar -->
                        <button type="submit" class="bg-green-400 p-2 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('Icons/save.png') }}" alt="Ícone Salvar" class="h-12 w-12 object-contain" />
                        </button>

                        <!-- Botão Lixeira -->
                        <button onclick="window.location.href='/admin/Cardapio'" class="bg-red-400 p-2 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('Icons/trash.png') }}" alt="Ícone Lixeira" class="h-12 w-12 object-contain" />
                        </button>
                    </div>
                </div>
            </div>


        </div>
        </fomr>
</div>

<script>
    // Função para alternar entre o select e o campo de input
    function handleCategoryChange(selectElement) {
        var newCategoryContainer = document.getElementById('newcategory-container');

        // Se o usuário escolher a opção "Adicionar Nova Categoria"
        if (selectElement.value === "novo") {
            newCategoryContainer.style.display = "block"; // Exibe o input para nova categoria
        } else {
            newCategoryContainer.style.display = "none"; // Esconde o input
        }
    }
</script>