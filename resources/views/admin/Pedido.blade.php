<div>
    <x-hotbar-admin />

    <div class="flex h-auto text-center">

        <!-- Coluna Agendados -->
        <div class="flex flex-1 flex-col p-4">
            <div class="bg-[#A7C7E7] p-4 w-full h-min mt-1">
                Agendados
            </div>
            <div id="agendados" class="bg-[#A7C7E7] p-4 w-full mt-1">
                <!-- Pedidos agendados serão carregados aqui via AJAX -->
            </div>
        </div>

        <!-- Coluna Pedidos -->
        <div class="flex flex-1 flex-col p-4">
            <div class="p-4 w-full h-min bg-[#F2A97E]">
                Pedidos
            </div>
            <div id="pedidos" class="p-4 w-full h-min mt-1 bg-[#F2A97E]">
                <!-- Pedidos pendentes serão carregados aqui via AJAX -->
            </div>
        </div>

        <!-- Coluna Em andamento -->
        <div class="flex flex-1 flex-col p-4">
            <div class="p-4 w-full h-min bg-[#F9E3A1]">
                Em andamento
            </div>
            <div id="em-andamento" class="p-4 w-full h-min mt-1 bg-[#F9E3A1] ">
                <!-- Pedidos em andamento serão carregados aqui via AJAX -->
            </div>
        </div>

    </div>
</div>

<!-- Adicione jQuery e o script para buscar pedidos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function carregarPedidos() {
        $.ajax({
            url: "{{ route('pedidos.json') }}",
            method: 'GET',
            success: function(response) {
                // Limpa as colunas
                $('#agendados').empty();
                $('#pedidos').empty();
                $('#em-andamento').empty();

                // Preenche a coluna Agendados
                response.agendamentos.forEach(function(pedido) {
                    // Cria uma string com os nomes dos itens do pedido

                    $('#agendados').append(`
                        <div class="mb-4 mt-1 bg-[#A7C7E7]  border-2 border-black border-opacity-30">
                            <p>Para: ${pedido.id}</p>
                            <p>Nome: ${pedido.nome}</p>
                            <p>Contato: ${pedido.id}</p>
                            <p>Opção: ${pedido.status_pedido}</p>
                            <p>ID: ${pedido.id}</p>
                            <p>Valor: ${pedido.id}</p>
                            <p>Itens: ${itensNomes}</p> <!-- Aqui é onde mostramos os nomes dos itens -->
                            <p>Comentarios: ${pedido.id}</p>

                            <div class="flex space-x-4 justify-center m-4">
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                            </div>
                        </div>
                    `);
                });


                // Preenche a coluna Pedidos
                response.pendentes.forEach(function(pedido) {
                    $('#pedidos').append(`
                        <div class="mb-4 mt-1 bg-[#F2A97E] border-2 border-black border-opacity-30">
                            <p>Nome: ${pedido.nome}</p>
                            <p>Status: ${pedido.status_pedido}</p>
                            <p>ID: ${pedido.id}</p>
                            <div class="flex space-x-4 justify-center m-4">
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                            </div>
                        </div>
                    `);
                });

                // Preenche a coluna Em andamento
                response.em_andamento.forEach(function(pedido) {
                    $('#em-andamento').append(`
                        <div class="mb-4 mt-1 bg-[#F9E3A1] border-2 border-black border-opacity-30">
                            <p>Nome: ${pedido.nome}</p>
                            <p>Status: ${pedido.status_pedido}</p>
                            <p>ID: ${pedido.id}</p>
                            <div class="flex space-x-4 justify-center m-4">
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-6 py-2 rounded-lg flex items-center space-x-2" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                                </button>
                            </div>
                        </div>
                    `);
                });
            }
        });
    }

    // Carrega os pedidos ao carregar a página
    $(document).ready(function() {
        carregarPedidos();
    });

    // Atualiza os pedidos a cada 5 segundos
    setInterval(carregarPedidos, 5000);
</script>