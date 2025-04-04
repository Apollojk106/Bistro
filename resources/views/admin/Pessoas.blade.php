<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <x-hotbar-admin />

    <style>
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 200ms, transform 200ms;
        }
        .dropdown-exit {
            opacity: 1;
        }
        .dropdown-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 200ms, transform 200ms;
        }
    </style>
</head>
<body class="bg-[#f5f5f5] text-black">

<div class="container mx-auto p-4 max-w-5xl">
    <!-- Barra de filtro e pesquisa -->
    <div class="bg-[#e0e0e0] rounded-lg p-4 mb-4 shadow">
        <div class="flex justify-between items-center">
            <!-- Filtro dropdown -->
            <div class="relative">
                <button id="filterButton" class="flex items-center space-x-2 bg-white hover:bg-gray-200 px-4 py-2 rounded-lg transition border border-gray-300">
                    <span id="currentFilter">Nome</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="filterDropdown" class="hidden absolute z-10 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-300">
                    <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-t-lg" data-filter="name">Nome (A-Z)</button>
                    <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-100" data-filter="id">ID (Crescente)</button>
                    <button class="filter-option block w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-lg" data-filter="situation">Situação (Negativos)</button>
                </div>
            </div>
            
            <!-- Barra de pesquisa -->
            <div class="relative w-1/2">
                <input type="text" id="searchInput" placeholder="Pesquisar..." class="w-full bg-white rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-[#ff6d00] border border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Cabeçalho da tabela -->
    <div class="bg-[#e0e0e0] rounded-t-lg p-3 grid grid-cols-12 gap-1 font-bold text-sm">
        <div class="col-span-3">Nome</div>
        <div class="col-span-2">Id</div>
        <div class="col-span-2">Situação</div>
        <div class="col-span-2">Dados</div>
        <div class="col-span-3">Anotações</div>
    </div>
    
    <!-- Linha laranja -->
    <div class="h-1 bg-[#ff6d00]"></div>
    
    <!-- Lista de clientes -->
    <div id="clientList" class="bg-[#ff6d00] rounded-b-lg divide-y divide-[#ff9e40]">
        <!-- Cliente exemplo -->
        <div class="client-item grid grid-cols-12 gap-1 items-center p-3 hover:bg-[#ff9e40] transition text-sm" data-id="10" data-name="Apollo Henrique" data-situation="-43">
            <div class="col-span-3 name">Apollo Henrique</div>
            <div class="col-span-2 id">10</div>
            <div class="col-span-2 situation text-red-600 font-medium">R$-43</div>
            <div class="col-span-2 flex justify-start">
                <button class="expand-btn p-1 hover:bg-[#ff6d00] rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="clipboard-btn p-1 hover:bg-[#ff6d00] rounded transition ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                    </svg>
                </button>
            </div>
            <div class="col-span-3 flex justify-start">
                <button class="edit-btn p-1 hover:bg-[#ff6d00] rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </button>
                <button class="delete-btn p-1 hover:bg-red-600 rounded transition ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mais clientes podem ser adicionados dinamicamente -->
    </div>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-96 text-gray-800">
        <h3 class="text-xl font-bold mb-4">Editar Cliente</h3>
        <div class="space-y-4">
            <div>
                <label class="block mb-1">Nome</label>
                <input type="text" id="editName" class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00] border border-gray-300">
            </div>
            <div>
                <label class="block mb-1">Situação</label>
                <input type="number" id="editSituation" class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00] border border-gray-300">
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6">
            <button id="cancelEdit" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg transition">Cancelar</button>
            <button id="saveEdit" class="px-4 py-2 bg-[#ff6d00] hover:bg-[#ff8500] text-white rounded-lg transition">Salvar</button>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-96 text-gray-800">
        <h3 class="text-xl font-bold mb-4">Confirmar Exclusão</h3>
        <p class="mb-4">Tem certeza que deseja excluir este cliente?</p>
        <div id="passwordSection" class="hidden">
            <label class="block mb-1">Digite a senha para confirmar:</label>
            <input type="password" id="deletePassword" class="w-full bg-gray-100 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-[#ff6d00] border border-gray-300">
            <p id="passwordError" class="text-red-600 text-sm hidden">Senha incorreta!</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg transition">Cancelar</button>
            <button id="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">Excluir</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variáveis globais
        let currentClientId = null;
        let clients = [
            { id: 10, name: 'Apollo Henrique', situation: -43 },
            { id: 5, name: 'Maria Silva', situation: 120 },
            { id: 7, name: 'João Oliveira', situation: -15 },
            { id: 3, name: 'Ana Santos', situation: 200 },
            { id: 12, name: 'Carlos Pereira', situation: -80 }
        ];
        
        // Elementos do DOM
        const filterButton = document.getElementById('filterButton');
        const filterDropdown = document.getElementById('filterDropdown');
        const currentFilter = document.getElementById('currentFilter');
        const searchInput = document.getElementById('searchInput');
        const clientList = document.getElementById('clientList');
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        const passwordSection = document.getElementById('passwordSection');
        
        // Inicializar lista de clientes
        renderClientList(clients);
        
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
                let sortedClients = [...clients];
                
                switch(filterType) {
                    case 'name':
                        sortedClients.sort((a, b) => a.name.localeCompare(b.name));
                        break;
                    case 'id':
                        sortedClients.sort((a, b) => a.id - b.id);
                        break;
                    case 'situation':
                        sortedClients.sort((a, b) => a.situation - b.situation);
                        break;
                }
                
                renderClientList(sortedClients);
            });
        });
        
        // Barra de pesquisa
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.toLowerCase();
                const filteredClients = clients.filter(client => 
                    client.name.toLowerCase().includes(searchTerm) || 
                    client.id.toString().includes(searchTerm) ||
                    client.situation.toString().includes(searchTerm)
                );
                renderClientList(filteredClients);
            }
        });
        
        // Botões de ação (adicionados via event delegation)
        clientList.addEventListener('click', function(e) {
            const clientItem = e.target.closest('.client-item');
            if (!clientItem) return;
            
            currentClientId = parseInt(clientItem.getAttribute('data-id'));
            const client = clients.find(c => c.id === currentClientId);
            
            // Botão de expandir
            if (e.target.closest('.expand-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                // Alternar estado ativo
                const expandBtn = clientItem.querySelector('.expand-btn');
                const isActive = expandBtn.classList.contains('bg-[#ff6d00]');
                
                // Resetar todos os botões
                document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                    btn.classList.remove('bg-[#ff6d00]');
                });
                
                // Ativar apenas se não estava ativo antes
                if (!isActive) {
                    expandBtn.classList.add('bg-[#ff6d00]');
                    alert(`Expandindo informações de ${client.name}`);
                }
            }
            
            // Botão de prancheta
            if (e.target.closest('.clipboard-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                // Alternar estado ativo
                const clipboardBtn = clientItem.querySelector('.clipboard-btn');
                const isActive = clipboardBtn.classList.contains('bg-[#ff6d00]');
                
                // Resetar todos os botões
                document.querySelectorAll('.expand-btn, .clipboard-btn').forEach(btn => {
                    btn.classList.remove('bg-[#ff6d00]');
                });
                
                // Ativar apenas se não estava ativo antes
                if (!isActive) {
                    clipboardBtn.classList.add('bg-[#ff6d00]');
                    alert(`Copiando informações de ${client.name} para área de transferência`);
                }
            }
            
            // Botão de editar
            if (e.target.closest('.edit-btn')) {
                e.preventDefault();
                e.stopPropagation();
                
                document.getElementById('editName').value = client.name;
                document.getElementById('editSituation').value = client.situation;
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
        
        document.getElementById('saveEdit').addEventListener('click', function() {
            const newName = document.getElementById('editName').value.trim();
            const newSituation = parseInt(document.getElementById('editSituation').value);
            
            if (!newName) {
                alert('O nome não pode estar vazio!');
                return;
            }
            
            // Atualizar cliente
            const clientIndex = clients.findIndex(c => c.id === currentClientId);
            if (clientIndex !== -1) {
                clients[clientIndex].name = newName;
                clients[clientIndex].situation = newSituation;
                renderClientList(clients);
                alert('Alterações salvas com sucesso!');
            }
            
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
                    // Excluir cliente
                    clients = clients.filter(c => c.id !== currentClientId);
                    renderClientList(clients);
                    deleteModal.classList.add('hidden');
                    alert('Cliente excluído com sucesso!');
                } else {
                    document.getElementById('passwordError').classList.remove('hidden');
                }
            } else {
                // Mostrar campo de senha
                passwordSection.classList.remove('hidden');
            }
        });
        
        // Função para renderizar a lista de clientes
        function renderClientList(clientsToRender) {
            clientList.innerHTML = '';
            
            if (clientsToRender.length === 0) {
                clientList.innerHTML = '<div class="p-4 text-center">Nenhum cliente encontrado</div>';
                return;
            }
            
            clientsToRender.forEach(client => {
                const situationClass = client.situation < 0 ? 'text-red-600 font-medium' : 'text-black';
                
                const clientItem = document.createElement('div');
                clientItem.className = 'client-item grid grid-cols-12 gap-1 items-center p-3 hover:bg-[#ff9e40] transition text-sm';
                clientItem.setAttribute('data-id', client.id);
                clientItem.setAttribute('data-name', client.name);
                clientItem.setAttribute('data-situation', client.situation);
                
                clientItem.innerHTML = `
                    <div class="col-span-3 name">${client.name}</div>
                    <div class="col-span-2 id">${client.id}</div>
                    <div class="col-span-2 situation ${situationClass}">R$${client.situation}</div>
                    <div class="col-span-2 flex justify-start">
                        <button class="expand-btn p-1 hover:bg-[#ff6d00] rounded transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button class="clipboard-btn p-1 hover:bg-[#ff6d00] rounded transition ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                            </svg>
                        </button>
                    </div>
                    <div class="col-span-3 flex justify-start">
                        <button class="edit-btn p-1 hover:bg-[#ff6d00] rounded transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                        <button class="delete-btn p-1 hover:bg-red-600 rounded transition ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                `;
                
                clientList.appendChild(clientItem);
            });
        }
    });
</script>

</body>
</html>