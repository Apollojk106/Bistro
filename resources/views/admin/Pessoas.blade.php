<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
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
                    <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-b-lg" data-filter="situation">Saldo (Negativos)</button>
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
        <div class="col-span-2">ID</div>
        <div class="col-span-2">Saldo</div>
        <div class="col-span-2">Dados</div>
        <div class="col-span-3">Anotações</div>
    </div>
    
    <!-- Lista de clientes -->
    <div id="clientList" class="rounded-b-lg">
        @forelse($clientes as $cliente)
        <div class="client-card grid grid-cols-12 gap-1 items-center p-3 hover:bg-gray-50 transition text-sm" 
             data-id="{{ $cliente->id }}" 
             data-name="{{ $cliente->nome }}" 
             data-situation="{{ $cliente->saldo }}">
            
            <div class="col-span-3 name">{{ $cliente->nome }}</div>
            <div class="col-span-2 id">{{ $cliente->id }}</div>
            <div class="col-span-2 situation {{ $cliente->saldo < 0 ? 'text-red-500 font-medium' : 'text-gray-800' }}">
                R$ {{ number_format($cliente->saldo, 2, ',', '.') }}
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
                    <form action="{{ route('admin.pessoas.destroy', $cliente->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn p-1 hover:bg-red-50 rounded transition ml-1">
                            <img src="{{ asset('Icons/trash-red.png') }}" alt="Excluir" class="icon-img">
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Painel de detalhes -->
            <div class="client-details hidden col-span-12 mt-3 p-4 bg-gray-50 rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="detail-label">Nome Completo</div>
                        <div class="detail-value">{{ $cliente->nome }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Apelido</div>
                        <div class="detail-value">{{ $cliente->apelido ?? 'Não informado' }}</div>
                    </div>
                    <div>
                        <div class="detail-label">E-mail</div>
                        <div class="detail-value">{{ $cliente->email }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Telefone</div>
                        <div class="detail-value">{{ $cliente->telefone }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="detail-label">Endereço</div>
                        <div class="detail-value">
                            {{ $cliente->rua }}, {{ $cliente->numero_residencia }} - 
                            {{ $cliente->bairro }} {{ $cliente->complemento ? '('.$cliente->complemento.')' : '' }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Saldo</div>
                        <div class="detail-value {{ $cliente->saldo < 0 ? 'text-red-500' : '' }}">
                            R$ {{ number_format($cliente->saldo, 2, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Total de Pedidos</div>
                        <div class="detail-value">{{ $cliente->total_pedidos }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="detail-label">Último Pedido</div>
                        <div class="detail-value">
                            @if($cliente->ultimo_pedido)
                                #{{ $cliente->ultimo_pedido->id }} - 
                                {{ $cliente->ultimo_pedido->created_at->format('d/m/Y H:i') }} - 
                                R$ {{ number_format($cliente->ultimo_pedido->valor_total, 2, ',', '.') }}
                            @else
                                Nenhum pedido registrado
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Painel de anotações -->
            <div class="client-notes hidden col-span-12 mt-3 p-4 bg-gray-50 rounded-lg">
                <div class="notes-content">
                    @forelse($cliente->anotacoes as $anotacao)
                    <div class="detail-item mb-3">
                        <div class="detail-label">
                            {{ $anotacao->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="detail-value">
                            {{ $anotacao->conteudo }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">
                        Nenhuma anotação encontrada
                    </div>
                    @endforelse
                </div>
                
                <form action="{{ route('admin.clientes.anotacoes.store', $cliente->id) }}" method="POST" class="mt-4">
                    @csrf
                    <textarea name="conteudo" class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] resize-none" placeholder="Digite suas anotações aqui..." rows="3" required></textarea>
                    <button type="submit" class="w-full bg-[#ff6d00] hover:bg-[#ff8500] text-white py-2 px-4 rounded-lg transition font-medium mt-2">
                        Salvar Anotação
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500 bg-white rounded-b-lg">Nenhum cliente encontrado</div>
        @endforelse
    </div>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-96 text-gray-800">
        <h3 class="text-xl font-bold mb-4">Editar Cliente</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block mb-1 text-sm font-medium">Nome</label>
                    <input type="text" name="nome" id="editName" class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">E-mail</label>
                    <input type="email" name="email" id="editEmail" class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium">Telefone</label>
                    <input type="text" name="telefone" id="editPhone" class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" id="cancelEdit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-[#ff6d00] hover:bg-[#ff8500] text-white rounded-lg transition text-sm font-medium">Salvar</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro dropdown
        const filterButton = document.getElementById('filterButton');
        const filterDropdown = document.getElementById('filterDropdown');
        const currentFilter = document.getElementById('currentFilter');
        
        filterButton.addEventListener('click', function(e) {
            e.stopPropagation();
            filterDropdown.classList.toggle('hidden');
        });
        
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
                
                // Obter todos os clientes
                const clientCards = Array.from(document.querySelectorAll('.client-card'));
                
                // Ordenar clientes
                switch(filterType) {
                    case 'name':
                        clientCards.sort((a, b) => {
                            const nameA = a.querySelector('.name').textContent.toLowerCase();
                            const nameB = b.querySelector('.name').textContent.toLowerCase();
                            return nameA.localeCompare(nameB);
                        });
                        break;
                    case 'id':
                        clientCards.sort((a, b) => {
                            const idA = parseInt(a.querySelector('.id').textContent);
                            const idB = parseInt(b.querySelector('.id').textContent);
                            return idA - idB;
                        });
                        break;
                    case 'situation':
                        clientCards.sort((a, b) => {
                            const situationA = parseFloat(a.getAttribute('data-situation'));
                            const situationB = parseFloat(b.getAttribute('data-situation'));
                            return situationA - situationB;
                        });
                        break;
                }
                
                // Reordenar na tela
                const clientList = document.getElementById('clientList');
                clientCards.forEach(card => clientList.appendChild(card));
            });
        });
        
        // Barra de pesquisa
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.client-card').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? 'grid' : 'none';
            });
        });
        
        // Botões de ação (adicionados via event delegation)
        document.getElementById('clientList').addEventListener('click', function(e) {
            const clientItem = e.target.closest('.client-card');
            if (!clientItem) return;
            
            const clientId = clientItem.getAttribute('data-id');
            const detailsPanel = clientItem.querySelector('.client-details');
            const notesPanel = clientItem.querySelector('.client-notes');
            
            // Botão de expandir (detalhes)
            if (e.target.closest('.expand-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                // Fechar todos os painéis abertos
                document.querySelectorAll('.client-details, .client-notes').forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Resetar todos os botões ativos
                document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                    btn.classList.remove('active-btn');
                });
                
                // Ativar o botão clicado
                const clickedBtn = e.target.closest('.expand-btn');
                clickedBtn.classList.add('active-btn');
                
                // Mostrar painel de detalhes
                detailsPanel.classList.toggle('hidden');
            }
            
            // Botão de prancheta (anotações)
            if (e.target.closest('.clipboard-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                // Fechar todos os painéis abertos
                document.querySelectorAll('.client-details, .client-notes').forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Resetar todos os botões ativos
                document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                    btn.classList.remove('active-btn');
                });
                
                // Ativar o botão clicado
                const clickedBtn = e.target.closest('.clipboard-btn');
                clickedBtn.classList.add('active-btn');
                
                // Mostrar painel de anotações
                notesPanel.classList.toggle('hidden');
            }
            
            // Botão de editar
            if (e.target.closest('.edit-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                const clientName = clientItem.querySelector('.name').textContent;
                const clientEmail = clientItem.querySelector('.email').textContent;
                const clientPhone = clientItem.querySelector('.phone').textContent;
                
                document.getElementById('editName').value = clientName;
                document.getElementById('editEmail').value = clientEmail;
                document.getElementById('editPhone').value = clientPhone;
                
                // Configurar o formulário de edição
                const editForm = document.getElementById('editForm');
                editForm.action = `/admin/pessoas/${clientId}`;
                
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
        
        // Modal de edição
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
                    // Enviar formulário de exclusão
                    const clientItem = document.querySelector(`.client-card[data-id="${currentClientId}"]`);
                    if (clientItem) {
                        const deleteForm = clientItem.querySelector('form[method="POST"]');
                        deleteForm.submit();
                    }
                } else {
                    document.getElementById('passwordError').classList.remove('hidden');
                }
            } else {
                // Mostrar campo de senha
                passwordSection.classList.remove('hidden');
            }
        });
    });
</script>

</body>
</html>