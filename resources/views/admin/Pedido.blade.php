<div>
    <x-hotbar-admin />

    <!-- Menu Flutuante para Celular -->
    <div class="fixed bottom-4 left-4 md:hidden z-50">
        <!-- Botão Flutuante -->
        <button id="menu-flutuante-btn" class="bg-[#B7B7B7] p-3 rounded-full shadow-lg">
            <img src="{{ asset('Icons/vector.png') }}" alt="Menu" class="h-6 w-6" />
        </button>

        <!-- Menu de Opções -->
        <div id="menu-flutuante-opcoes" class="hidden bg-[#B7B7B7] p-2 rounded-lg mt-2 space-y-2">
            <button onclick="scrollParaCard('agendados')" class="block w-full text-left p-2 hover:bg-gray-200 rounded">
                Agendados
            </button>
            <button onclick="scrollParaCard('pedidos')" class="block w-full text-left p-2 hover:bg-gray-200 rounded">
                Pedidos
            </button>
            <button onclick="scrollParaCard('em-andamento')" class="block w-full text-left p-2 hover:bg-gray-200 rounded">
                Em andamento
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen text-center">

        <!-- Coluna Agendados -->
        <div id="agendados-card" class="flex-1 p-2 w-full">
            <div class="bg-[#A7C7E7] p-2 w-full h-min">
                Agendados
            </div>
            <div id="agendados" class="bg-[#A7C7E7] p-2 w-full mt-1">
                <!-- Pedidos agendados serão carregados aqui via AJAX -->
            </div>
        </div>

        <!-- Coluna Pedidos -->
        <div id="pedidos-card" class="flex-1 p-2 w-full">
            <div class="p-2 w-full h-min bg-[#F2A97E]">
                Pedidos
            </div>
            <div id="pedidos" class="p-2 w-full h-min mt-1 bg-[#F2A97E]">
                <!-- Pedidos pendentes serão carregados aqui via AJAX -->
            </div>
        </div>

        <!-- Coluna Em andamento -->
        <div id="em-andamento-card" class="flex-1 p-2 w-full">
            <div class="p-2 w-full h-min bg-[#F9E3A1]">
                Em andamento
            </div>
            <div id="em-andamento" class="p-2 w-full h-min mt-1 bg-[#F9E3A1]">
                <!-- Pedidos em andamento serão carregados aqui via AJAX -->
            </div>
        </div>

    </div>
</div>

<!-- Adicione jQuery e o script para buscar pedidos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Função para rolar até o card correspondente
    function scrollParaCard(id) {
        const card = document.getElementById(`${id}-card`);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Mostrar/ocultar o menu flutuante
    document.getElementById('menu-flutuante-btn').addEventListener('click', function() {
        const menuOpcoes = document.getElementById('menu-flutuante-opcoes');
        menuOpcoes.classList.toggle('hidden');
    });

    // Fechar o menu ao clicar fora dele
    document.addEventListener('click', function(event) {
        const menuBtn = document.getElementById('menu-flutuante-btn');
        const menuOpcoes = document.getElementById('menu-flutuante-opcoes');
        if (!menuBtn.contains(event.target) && !menuOpcoes.contains(event.target)) {
            menuOpcoes.classList.add('hidden');
        }
    });

    // Função para carregar pedidos (mantida igual)
    function carregarPedidos() {
        $.ajax({
            url: "{{ route('pedidos.json') }}",
            method: 'GET',
            success: function(response) {
                // Limpa as colunas
                $('#agendados').empty();
                $('#pedidos').empty();
                $('#em-andamento').empty();

                // Função para gerar o endereço completo, caso a categoria seja "Entrega"
                function gerarEnderecoCompleto(pedido) {
                    if (pedido.categoria_pedido === 'Entrega') {
                        return `
                            <p>Endereço: <br>${pedido.rua}, ${pedido.numero_residencia}, ${pedido.bairro} ${pedido.complemento ? `<br> ${pedido.complemento}` : ''}</p>
                        `;
                    }
                    return ''; // Retorna uma string vazia se não for "Entrega"
                }

                // Preenche a coluna Agendados
                response.agendamentos.forEach(function(pedido) {
                    let enderecoCompleto = gerarEnderecoCompleto(pedido); // Gerar endereço completo

                    $('#agendados').append(`
                        <div class="mb-2 mt-1 bg-[#A7C7E7] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.status_pedido}</p>
                            <p class="text-sm"><strong>Para:</strong> ${pedido.horario}</p>
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto} <!-- Endereço será mostrado aqui se for "Entrega" -->

                            <div class="flex space-x-2 justify-center mt-2">
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
                                </button>
                            </div>
                        </div>
                    `);
                });

                // Preenche a coluna Pedidos
                response.pendentes.forEach(function(pedido) {
                    let enderecoCompleto = gerarEnderecoCompleto(pedido); // Gerar endereço completo

                    $('#pedidos').append(`
                        <div class="mb-2 mt-1 bg-[#F2A97E] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.status_pedido}</p>
                            <p class="text-sm"><strong>Para:</strong> ${pedido.horario}</p>
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto} <!-- Endereço será mostrado aqui se for "Entrega" -->

                            <div class="flex space-x-2 justify-center mt-2">
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
                                </button>
                            </div>
                        </div>
                    `);
                });

                // Preenche a coluna Em andamento
                response.em_andamento.forEach(function(pedido) {
                    let enderecoCompleto = gerarEnderecoCompleto(pedido); // Gerar endereço completo

                    $('#em-andamento').append(`
                        <div class="mb-2 mt-1 bg-[#F9E3A1] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.status_pedido}</p>
                            <p class="text-sm"><strong>Para:</strong> ${pedido.horario}</p>
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto} <!-- Endereço será mostrado aqui se for "Entrega" -->

                            <div class="flex space-x-2 justify-center mt-2">
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm">
                                    <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
                                </button>
                                <button class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm" onclick="window.location.href='/admin/Pedidos/Avancar/${pedido.id}'">
                                    <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-4 w-4 object-contain" />
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