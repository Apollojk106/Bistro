<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <x-hotbar-admin />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .client-card {
            margin-bottom: 8px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .icon-img {
            display: block;
            width: 20px;
            height: 20px;
        }

        .active-btn {
            background-color: #ff6d00;
        }

        .active-btn img {
            filter: brightness(0) invert(1);
        }

        /* Estilos para os painéis laterais */
        .side-panel {
            width: 420px;
            background-color: white;
            border-left: 1px solid #e2e8f0;
            padding: 24px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            transition: transform 0.3s ease;
            z-index: 900;
            transform: translateX(100%);
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .side-panel.active {
            transform: translateX(0);
        }

        .panel-header {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .client-name-display {
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 20px;
            padding: 10px 12px;
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .panel-content {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 16px;
        }

        .detail-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 14px;
            background-color: white;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto p-6 max-w-6xl">
        <!-- Barra de filtro e pesquisa -->
        <div class="bg-white rounded-lg p-4 mb-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <!-- Filtro dropdown -->
                <div class="relative">
                    <button id="filterButton" class="flex items-center space-x-2 bg-white hover:bg-gray-50 px-4 py-2 rounded-lg transition border border-gray-200 text-sm font-medium">
                        <span id="currentFilter">Nome (A-Z)</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="filterDropdown" class="hidden absolute z-10 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 text-sm">
                        <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-t-lg" data-filter="name">Nome (A-Z)</button>
                        <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-50" data-filter="id">ID (Crescente)</button>
                        <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-b-lg" data-filter="situation">Situação (Negativos)</button>
                    </div>
                </div>

                <!-- Barra de pesquisa -->
                <div class="relative w-1/2">
                    <input type="text" id="searchInput" placeholder="Pesquisar..." class="w-full bg-white rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                    <img src="{{ asset('Icons/search.png') }}" alt="Pesquisar" class="icon-img absolute left-3 top-2.5 text-gray-400">
                </div>
            </div>
        </div>

        <!-- Linha laranja -->
        <div class="h-[2px] bg-[#ff6d00] mb-4"></div>

        <!-- Cabeçalho da tabela -->
        <div class="bg-white rounded-t-lg p-3 grid grid-cols-12 gap-1 font-semibold text-sm border-b border-gray-100">
            <div class="col-span-3">Nome</div>
            <div class="col-span-2">Apelido</div>
            <div class="col-span-2">Situação</div>
            <div class="col-span-2">Dados</div>
            <div class="col-span-3">Anotações</div>
        </div>

        <!-- Lista de clientes -->
        <div id="clientList" class="rounded-b-lg">
            @forelse($clientes as $cliente)
            <div class="client-card grid grid-cols-12 gap-1 items-center p-3 hover:bg-gray-50 transition text-sm" 
                data-id="{{ $cliente->id ?? '' }}" 
                data-name="{{ $cliente->nome ?? '' }}" 
                data-situation="{{ $cliente->saldo ?? 0 }}"
                data-email="{{ $cliente->email ?? '' }}" 
                >

                <div class="col-span-3 name">{{ $cliente->nome ?? $cliente->apelido ?? '' }}</div>
                <div class="col-span-2 id">{{ $cliente->apelido ?? '' }}</div>
                <div class="col-span-2 situation {{ ($cliente->saldo ?? 0) < 0 ? 'text-red-500 font-medium' : 'text-gray-800' }}">
                    R$ {{ number_format($cliente->saldo ?? 0, 2, ',', '.') }}
                </div>
                <div class="col-span-2 flex justify-start">
                    <button class="expand-btn p-1 hover:bg-gray-100 rounded transition">
                        <img src="{{ asset('Icons/maximize.png') }}" alt="Maximizar" class="icon-img">
                    </button>
                </div>
                <div class="col-span-3 flex justify-between items-center">
                    <button class="clipboard-btn p-1 hover:bg-gray-100 rounded transition">
                        <img src="{{ asset('Icons/clipboard.png') }}" alt="Prancheta" class="icon-img">
                    </button>
                    <div class="flex">
                        <button class="edit-btn p-1 hover:bg-gray-100 rounded transition ml-1">
                            <img src="{{ asset('Icons/edit.png') }}" alt="Editar" class="icon-img">
                        </button>
                        <form action="{{ route('admin.pessoas.destroy', $cliente->id ?? '') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn p-1 hover:bg-red-50 rounded transition ml-1">
                                <img src="{{ asset('Icons/trash-red.png') }}" alt="Excluir" class="icon-img">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500 bg-white rounded-b-lg">Nenhum cliente encontrado</div>
            @endforelse
        </div>
    </div>

    <!-- Modal de Edição ATUALIZADO -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-96 text-gray-800">
            <h3 class="text-xl font-bold mb-1">Editar Cliente: <span id="modalClientName"></span></h3>
            <p class="text-sm text-gray-400 mb-4" id="modalClientEmail"></p>
            <input type="hidden" name="email" id="editClientEmail">
            <p class="text-sm text-gray-500 mb-4">Altere os dados abaixo</p>

            <form id="editClientForm" method="POST">
                @csrf
                <input type="hidden" name="client_id" id="editClientId">
            <input type="hidden" name="email" id="editClientEmail">

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium">Apelido</label>
                        <input type="text" name="apelido" id="editApelido"
                            class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Saldo Atual</div>
                        <div class="detail-value" id="currentBalance"></div>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium">Valor para ajustar no saldo</label>
                        <div class="flex">
                            <select name="tipo_ajuste" class="bg-gray-50 border border-gray-200 rounded-l-lg px-3 focus:outline-none text-sm">
                                <option value="adicionar">Adicionar</option>
                                <option value="subtrair">Subtrair</option>
                            </select>
                            <input type="number" step="0.01" name="valor_ajuste" placeholder="0,00"
                                class="flex-1 bg-gray-50 rounded-r-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border-t border-r border-b border-gray-200 text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelEdit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-[#ff6d00] hover:bg-[#ff8500] text-white rounded-lg transition text-sm font-medium">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-96 text-gray-800">
            <h3 class="text-xl font-bold mb-4">Confirmar Exclusão</h3>
            <p class="mb-4 text-sm">Tem certeza que deseja excluir este cliente?</p>
            <div id="passwordSection" class="hidden">
                <label class="block mb-1 text-sm font-medium">Digite a senha para confirmar:</label>
                <input type="password" id="deletePassword" class="w-full bg-gray-50 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                <p id="passwordError" class="text-red-600 text-sm hidden">Senha incorreta!</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">Cancelar</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium">Excluir</button>
            </div>
        </div>
    </div>

    <!-- Painel de Dados do Cliente -->
    <div id="detailsPanel" class="side-panel">
        <div class="panel-header flex justify-between items-center">
            <div class="text-lg font-semibold">Dados do Cliente</div>
            <button id="closeDetails" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div id="detailsClientName" class="client-name-display"></div>

        <div class="panel-content">
            <div class="detail-item">
                <div class="detail-label">Nome Completo</div>
                <div class="detail-value" id="detailFullName"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">E-mail</div>
                <div class="detail-value" id="detailEmail"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Telefone</div>
                <div class="detail-value" id="detailPhone"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Endereço</div>
                <div class="detail-value" id="detailAddress"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Bairro</div>
                <div class="detail-value" id="detailBairro"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Número</div>
                <div class="detail-value" id="detailNumero"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Complemento</div>
                <div class="detail-value" id="detailComplemento"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Saldo</div>
                <div class="detail-value" id="detailBalance"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Total de Pedidos</div>
                <div class="detail-value" id="detailTotalPedidos"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Total Pago</div>
                <div class="detail-value" id="detailTotalPago"></div>
            </div>
        </div>
    </div>

    <!-- Painel de Anotações -->
    <div id="notesPanel" class="side-panel">
        <div class="panel-header flex justify-between items-center">
            <div class="text-lg font-semibold">Anotações</div>
            <button id="closeNotes" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div id="notesClientName" class="client-name-display"></div>

        <div class="panel-content" id="notesContent">
            <div class="detail-item">
                <div class="detail-label">05/04/2025 20:11</div>
                <div class="detail-value">Escreva as anotações</div>
            </div>
        </div>

        <div class="mt-auto">
            <textarea id="notesInput" class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] resize-none" placeholder="Digite suas anotações aqui..." rows="4"></textarea>
            <button id="saveNote" class="w-full bg-[#ff6d00] hover:bg-[#ff8500] text-white py-2 px-4 rounded-lg transition font-medium mt-2">Salvar Anotação</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variáveis globais
            let currentClientId = null;
            let currentClientName = null;
            let activePanel = null;

            // Elementos do DOM
            const filterButton = document.getElementById('filterButton');
            const filterDropdown = document.getElementById('filterDropdown');
            const currentFilter = document.getElementById('currentFilter');
            const searchInput = document.getElementById('searchInput');
            const clientList = document.getElementById('clientList');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            const passwordSection = document.getElementById('passwordSection');

            // Painéis laterais
            const detailsPanel = document.getElementById('detailsPanel');
            const notesPanel = document.getElementById('notesPanel');
            const closeDetails = document.getElementById('closeDetails');
            const closeNotes = document.getElementById('closeNotes');

            // Elementos de detalhes
            const detailsClientName = document.getElementById('detailsClientName');
            const detailFullName = document.getElementById('detailFullName');
            const detailEmail = document.getElementById('detailEmail');
            const detailPhone = document.getElementById('detailPhone');
            const detailAddress = document.getElementById('detailAddress');
            const detailBairro = document.getElementById('detailBairro');
            const detailNumero = document.getElementById('detailNumero');
            const detailComplemento = document.getElementById('detailComplemento');
            const detailBalance = document.getElementById('detailBalance');
            const detailTotalPedidos = document.getElementById('detailTotalPedidos');
            const detailTotalPago = document.getElementById('detailTotalPago');

            // Elementos de anotações
            const notesClientName = document.getElementById('notesClientName');
            const notesContent = document.getElementById('notesContent');
            const notesInput = document.getElementById('notesInput');
            const saveNote = document.getElementById('saveNote');

            // Filtro dropdown
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                filterDropdown.classList.toggle('hidden');
            });

            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function() {
                filterDropdown.classList.add('hidden');
            });

            // Selecionar opção de filtro
            document.querySelectorAll('.filter-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const filterType = this.getAttribute('data-filter');
                    currentFilter.textContent = this.textContent;
                    filterDropdown.classList.add('hidden');

                    // Aplicar filtro
                    const clientItems = Array.from(document.querySelectorAll('.client-card'));

                    clientItems.sort((a, b) => {
                        switch (filterType) {
                            case 'name':
                                return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                            case 'id':
                                return parseInt(a.getAttribute('data-id')) - parseInt(b.getAttribute('data-id'));
                            case 'situation':
                                return parseFloat(a.getAttribute('data-saldo')) - parseFloat(b.getAttribute('data-saldo'));
                        }
                    });

                    // Reordenar a lista
                    clientItems.forEach(item => clientList.appendChild(item));
                });
            });

            // Barra de pesquisa
            searchInput.addEventListener('keyup', function(e) {
                const searchTerm = this.value.toLowerCase();
                const clientItems = document.querySelectorAll('.client-card');

                clientItems.forEach(item => {
                    const name = item.getAttribute('data-name').toLowerCase();
                    const apelido = item.getAttribute('data-apelido').toLowerCase();
                    const id = item.getAttribute('data-id').toLowerCase();
                    const saldo = item.getAttribute('data-saldo').toLowerCase();

                    if (name.includes(searchTerm) || apelido.includes(searchTerm) ||
                        id.includes(searchTerm) || saldo.includes(searchTerm)) {
                        item.style.display = 'grid';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Configurar ação do botão de editar
            clientList.addEventListener('click', function(e) {
                const clientItem = e.target.closest('.client-card');
                if (!clientItem) return;

                currentClientId = clientItem.getAttribute('data-id');
                currentClientName = clientItem.getAttribute('data-name');

                // Botão de expandir (detalhes)
                if (e.target.closest('.expand-btn')) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Fechar painel ativo se existir
                    if (activePanel) {
                        activePanel.classList.remove('active');
                        document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                            btn.classList.remove('active-btn');
                        });
                    }

                    // Adiciona a classe apenas ao botão clicado
                    const clickedBtn = e.target.closest('.expand-btn');
                    clickedBtn.classList.add('active-btn');

                    // Mostrar painel de detalhes
                    activePanel = detailsPanel;
                    detailsPanel.classList.add('active');
                    loadClientDetails(clientItem);
                }

                // Botão de prancheta (anotações)
                if (e.target.closest('.clipboard-btn')) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Fechar painel ativo se existir
                    if (activePanel) {
                        activePanel.classList.remove('active');
                        document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                            btn.classList.remove('active-btn');
                        });
                    }

                    // Adiciona a classe apenas ao botão clicado
                    const clickedBtn = e.target.closest('.clipboard-btn');
                    clickedBtn.classList.add('active-btn');

                    // Mostrar painel de anotações
                    activePanel = notesPanel;
                    notesPanel.classList.add('active');
                    notesClientName.textContent = currentClientName;
                }

                // Botão de editar
                if (e.target.closest('.edit-btn')) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Preencher o modal
                    document.getElementById('modalClientName').textContent = currentClientName;
                    document.getElementById('editClientId').value = currentClientId;
                    document.getElementById('editApelido').value = clientItem.getAttribute('data-apelido');

                    // Preencher o e-mail
                    const clientEmail = clientItem.getAttribute('data-email');
                    document.getElementById('modalClientEmail').textContent = clientEmail;
                    document.getElementById('editClientEmail').value = clientEmail;

                    // Mostrar saldo atual formatado igual ao painel de detalhes
                    const saldoAtual = parseFloat(clientItem.getAttribute('data-situation'));
                    const currentBalanceElement = document.getElementById('currentBalance');
                    currentBalanceElement.textContent = `R$ ${saldoAtual.toFixed(2).replace('.', ',')}`;
                    currentBalanceElement.className = saldoAtual < 0 ? 'detail-value text-red-500' : 'detail-value';

                    // Mostrar modal
                    editModal.classList.remove('hidden');
                }

                // Botão de excluir
                if (e.target.closest('.delete-btn')) {
                    e.preventDefault();
                    e.stopPropagation();

                    deleteModal.classList.remove('hidden');
                    passwordSection.classList.add('hidden');
                    document.getElementById('deletePassword').value = '';
                    document.getElementById('passwordError').classList.add('hidden');
                }
            });

            // Cancelar edição
            document.getElementById('cancelEdit').addEventListener('click', function() {
                editModal.classList.add('hidden');
            });

            // Modal de exclusão
            document.getElementById('cancelDelete').addEventListener('click', function() {
                deleteModal.classList.add('hidden');
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (!passwordSection.classList.contains('hidden')) {
                    // Verificar senha
                    if (document.getElementById('deletePassword').value === 'terraço') {
                        // Excluir cliente via formulário normal (já que é DELETE)
                        const form = document.querySelector(`form[action*="${currentClientId}"]`);
                        if (form) {
                            form.submit();
                        }

                        deleteModal.classList.add('hidden');

                        // Fechar painéis laterais se estiverem abertos
                        detailsPanel.classList.remove('active');
                        notesPanel.classList.remove('active');
                        document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                            btn.classList.remove('active-btn');
                        });
                    } else {
                        document.getElementById('passwordError').classList.remove('hidden');
                    }
                } else {
                    // Mostrar campo de senha
                    passwordSection.classList.remove('hidden');
                }
            });

            // Fechar painéis laterais
            closeDetails.addEventListener('click', function() {
                detailsPanel.classList.remove('active');
                document.querySelectorAll('.expand-btn').forEach(btn => {
                    btn.classList.remove('active-btn');
                });
                activePanel = null;
            });

            closeNotes.addEventListener('click', function() {
                notesPanel.classList.remove('active');
                document.querySelectorAll('.clipboard-btn').forEach(btn => {
                    btn.classList.remove('active-btn');
                });
                activePanel = null;
            });

            // Fechar painéis ao clicar fora
            document.addEventListener('click', function(e) {
                if (!detailsPanel.contains(e.target) && !e.target.closest('.expand-btn') &&
                    !notesPanel.contains(e.target) && !e.target.closest('.clipboard-btn')) {

                    detailsPanel.classList.remove('active');
                    notesPanel.classList.remove('active');
                    document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                        btn.classList.remove('active-btn');
                    });
                    activePanel = null;
                }
            });

            // Salvar nova anotação
            saveNote.addEventListener('click', function() {
                if (!currentClientId) return;

                const noteText = notesInput.value.trim();
                if (!noteText) {
                    alert('A anotação não pode estar vazia!');
                    return;
                }

                const now = new Date();
                const timeString = now.toLocaleString('pt-BR');

                const noteElement = document.createElement('div');
                noteElement.className = 'detail-item';
                noteElement.innerHTML = `
                <div class="detail-label">${timeString}</div>
                <div class="detail-value">${noteText}</div>
            `;

                notesContent.insertBefore(noteElement, notesContent.firstChild);
                notesInput.value = '';
            });

            // Função para carregar detalhes do cliente
            function loadClientDetails(clientItem) {
                const clientId = clientItem.getAttribute('data-id');
                const clientName = clientItem.getAttribute('data-name');
                const clientApelido = clientItem.getAttribute('data-apelido');
                const clientSaldo = parseFloat(clientItem.getAttribute('data-saldo'));

                detailsClientName.textContent = clientApelido ? `${clientName} (${clientApelido})` : clientName;
                detailFullName.textContent = clientName;
                detailBalance.textContent = `R$ ${clientSaldo.toFixed(2).replace('.', ',')}`;
                detailBalance.className = clientSaldo < 0 ? 'detail-value text-red-500' : 'detail-value';

                // Preencher outros campos (substitua por dados reais ou requisição AJAX)
                detailEmail.textContent = "carregando...";
                detailPhone.textContent = "carregando...";
                detailAddress.textContent = "carregando...";
                detailBairro.textContent = "carregando...";
                detailNumero.textContent = "carregando...";
                detailComplemento.textContent = "carregando...";
                detailTotalPedidos.textContent = "carregando...";
                detailTotalPago.textContent = "carregando...";
            }
        });
    </script>

</body>

</html>