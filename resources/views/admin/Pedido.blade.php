<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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
            card.scrollIntoView({
                behavior: 'smooth'
            });
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

    // Função para voltar pedido para "Pedidos"
    function voltarParaPedidos(pedidoId) {
        if (confirm('Deseja realmente voltar este pedido para a lista de Pedidos?')) {
            $.ajax({
                url: '/admin/Pedidos/Voltar/' + pedidoId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        carregarPedidos(); // Recarrega os pedidos
                    } else {
                        alert('Erro ao voltar pedido: ' + response.message);
                    }
                },
                error: function() {
                    alert('Erro ao comunicar com o servidor');
                }
            });
        }
    }

    // Função para carregar pedidos
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

                // Função para mostrar horário apenas se não for null
                function mostrarHorario(horario) {
                    return horario ? `<p class="text-sm"><strong>Para:</strong> ${horario}</p>` : '';
                }

                // Preenche a coluna Agendados
                response.agendamentos.forEach(function(pedido) {
                    let enderecoCompleto = gerarEnderecoCompleto(pedido);
                    let horarioDisplay = mostrarHorario(pedido.horario);

                    $('#agendados').append(`
                        <div class="mb-2 mt-1 bg-[#A7C7E7] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.formapagamento} - ${pedido.status_pedido}</p>
                            ${horarioDisplay}
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto}

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
                    let enderecoCompleto = gerarEnderecoCompleto(pedido);
                    let horarioDisplay = mostrarHorario(pedido.horario);

                    $('#pedidos').append(`
                        <div class="mb-2 mt-1 bg-[#F2A97E] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.formapagamento} - ${pedido.status_pedido}</p>
                            ${horarioDisplay}
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto}

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

                // Preenche a coluna Em andamento com botão único de confirmação
                response.em_andamento.forEach(function(pedido) {
                    let enderecoCompleto = gerarEnderecoCompleto(pedido);
                    let horarioDisplay = mostrarHorario(pedido.horario);

                    $('#em-andamento').append(`
                        <div class="mb-2 mt-1 bg-[#F9E3A1] border-2 border-black border-opacity-30 p-2 rounded-lg">
                            <p class="text-sm"><strong>Pagamento:</strong> ${pedido.formapagamento} - ${pedido.status_pedido}</p>
                            ${horarioDisplay}
                            <p class="text-sm"><strong>Nome:</strong> ${pedido.nome}</p>
                            <p class="text-sm"><strong>Contato:</strong> ${pedido.telefone}</p>
                            <p class="text-sm"><strong>Opção:</strong> ${pedido.categoria_pedido}</p>
                            <p class="text-sm"><strong>Items:</strong> ${pedido.Items}</p>
                            <p class="text-sm"><strong>Valor:</strong> ${pedido.valor_total}</p>
                            <p class="text-sm"><strong>Comentários:</strong><br> ${pedido.descricao}</p>

                            ${enderecoCompleto}

                            <div class="flex justify-between mt-2">
                                <button onclick="voltarParaPedidos(${pedido.id})" class="bg-gray-500 text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm">
                                    <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="h-4 w-4 object-contain" />
                                </button>
                                <button onclick="abrirModalPagamento(
                                    ${pedido.id}, 
                                    '${pedido.status_pedido || ''}', 
                                    '${pedido.formapagamento ? pedido.formapagamento.replace(/'/g, "\\'") : ''}', 
                                    ${pedido.valor_pago ?? pedido.valor_total},
                                    ${pedido.valor_total}
                                )" 
                                    class="bg-[#A74A04] text-white px-4 py-1 rounded-lg flex items-center space-x-1 text-sm">
                                    <span>Confirmar Pedido</span>
                                </button>
                            </div>
                        </div>
                    `);
                });
            }
        });
    }

    // Função para abrir o modal de pagamento com os dados atuais
    function abrirModalPagamento(pedidoId, statusAtual, formaPagamentoAtual, valorPagoAtual, valorBrutoAtual) {
        const modalHTML = `
        <div id="modal-pagamento" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-4 rounded-lg w-full max-w-md">
                <h3 class="font-bold text-lg mb-4">Confirmar Conclusão - Pedido #${pedidoId}</h3>
                
                <form id="form-pagamento" action="/Atualizar/Pedidos" method="POST">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    <input type="hidden" name="pedido_id" value="${pedidoId}">

                    <div class="mb-4">
                        <label for="forma_pagamento" class="block text-sm font-medium mb-2">Forma de Pagamento:</label>
                        <select id="forma_pagamento" name="forma_pagamento" class="w-full p-2 border rounded" required>
                            <option value="">Selecione...</option>
                            <option value="Dinheiro" ${formaPagamentoAtual === 'Dinheiro' ? 'selected' : ''}>Dinheiro</option>
                            <option value="PIX" ${formaPagamentoAtual === 'PIX' ? 'selected' : ''}>PIX</option>
                            <option value="Cartão" ${formaPagamentoAtual === 'Cartão' ? 'selected' : ''}>Cartão</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Ajuste (Adicional/Desconto)</label>
                        <input type="number" id="valor_ajuste" name="valor_ajuste" step="0.01" value="0.00" class="w-full p-2 border rounded" required 
                               oninput="calcularValorPago(${valorBrutoAtual})">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Valor Total Atualizado</label>
                        <input type="text" id="valor_total_atualizado" class="w-full p-2 border rounded bg-gray-100" value="R$ ${valorBrutoAtual.toFixed(2)}" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Valor Pago</label>
                        <input type="number" id="valor_pago" name="valor_pago" step="0.01" value="${valorBrutoAtual.toFixed(2)}" class="w-full p-2 border rounded" required>
                    </div>

                    <p class="mb-4">Deseja marcar este pedido como concluído?</p>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-[#A74A04] text-white rounded">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    // Função para calcular o valor pago com base no ajuste
    function calcularValorPago(valorBruto) {
        const ajuste = parseFloat(document.getElementById('valor_ajuste').value) || 0;
        const valorTotalAtualizado = valorBruto + ajuste;

        // Atualiza o campo de valor total atualizado
        document.getElementById('valor_total_atualizado').value = `R$ ${valorTotalAtualizado.toFixed(2)}`;

        // Atualiza o campo de valor pago com o novo valor
        document.getElementById('valor_pago').value = valorTotalAtualizado.toFixed(2);
    }

    // Função para fechar o modal
    function fecharModal() {
        const modal = document.getElementById('modal-pagamento');
        if (modal) {
            modal.remove();
        }
    }

    // Carrega os pedidos ao carregar a página
    $(document).ready(function() {
        carregarPedidos();
    });

    // Atualiza os pedidos a cada 5 segundos
    setInterval(carregarPedidos, 5000);
</script>