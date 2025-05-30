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
            box-shadow: -4px 0 15px rgba(0,0,0,0.05);
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
        <div class="col-span-2">ID</div>
        <div class="col-span-2">Situação</div>
        <div class="col-span-2">Dados</div>
        <div class="col-span-3">Anotações</div>
    </div>
    
    <!-- Lista de clientes -->
    <div id="clientList" class="rounded-b-lg">
        @forelse($clientes as $cliente)
        <div class="client-card grid grid-cols-12 gap-1 items-center p-3 hover:bg-gray-50 transition text-sm" data-id="{{ $cliente->id }}" data-name="{{ $cliente->nome }}" data-situation="{{ $cliente->saldo }}">
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
        <div class="space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium">Nome</label>
                <input type="text" id="editName" class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Situação</label>
                <input type="number" id="editSituation" class="w-full bg-gray-50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff6d00]/50 focus:border-[#ff6d00] border border-gray-200 text-sm">
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6">
            <button id="cancelEdit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-sm font-medium">Cancelar</button>
            <button id="saveEdit" class="px-4 py-2 bg-[#ff6d00] hover:bg-[#ff8500] text-white rounded-lg transition text-sm font-medium">Salvar</button>
        </div>
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
    
    <div id="detailsClientName" class="client-name-display">Apollo Henrique</div>
    
    <div class="panel-content">
        <div class="detail-item">
            <div class="detail-label">Nome Completo</div>
            <div class="detail-value" id="detailFullName">Apollo Henrique Silva</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Apelido</div>
            <div class="detail-value" id="detailNickname">Apollo</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">CPF</div>
            <div class="detail-value" id="detailCpf">123.456.789-00</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">E-mail</div>
            <div class="detail-value" id="detailEmail">apollo@example.com</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Telefone</div>
            <div class="detail-value" id="detailPhone">(11) 98765-4321</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Endereço</div>
            <div class="detail-value" id="detailAddress">Rua das Flores, 123 - São Paulo/SP</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Saldo</div>
            <div class="detail-value text-red-500" id="detailBalance">R$ -43,00</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Total de Compras</div>
            <div class="detail-value" id="detailTotalPurchases">15 compras</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Comida Mais Pedida</div>
            <div class="detail-value" id="detailFavoriteFood">Pizza Calabresa</div>
        </div>
        
        <div class="detail-item">
            <div class="detail-label">Último Pedido</div>
            <div class="detail-value" id="detailLastOrder">Pizza Margherita (05/04/2025)</div>
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
    
    <div id="notesClientName" class="client-name-display">Apollo Henrique</div>
    
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
        let clients = [
            { 
                id: 10, 
                name: 'Apollo Henrique', 
                situation: -43,
                fullName: 'Apollo Henrique Silva',
                nickname: 'Apollo',
                cpf: '123.456.789-00',
                email: 'apollo@example.com',
                phone: '(11) 98765-4321',
                address: 'Rua das Flores, 123 - São Paulo/SP',
                totalPurchases: 15,
                favoriteFood: 'Pizza Calabresa',
                lastOrder: 'Pizza Margherita (05/04/2025)',
                notes: [
                    { text: "Cliente interessado no plano premium. Ligar na segunda-feira.", time: "04/04/2025 15:30" },
                    { text: "Escreva as anotações", time: "05/04/2025 20:11" }
                ]
            },
            { 
                id: 5, 
                name: 'Maria Silva', 
                situation: 120,
                fullName: 'Maria Silva Santos',
                nickname: 'Mari',
                cpf: '987.654.321-00',
                email: 'maria@example.com',
                phone: '(11) 91234-5678',
                address: 'Av. Paulista, 1000 - São Paulo/SP',
                totalPurchases: 8,
                favoriteFood: 'Lasanha',
                lastOrder: 'Lasanha Bolonhesa (03/04/2025)',
                notes: []
            },

            { 
                id: 7, 
                name: 'João Oliveira', 
                situation: -15,
                fullName: 'João Pedro Oliveira',
                nickname: 'JP',
                cpf: '456.789.123-00',
                email: 'joao@example.com',
                phone: '(21) 99876-5432',
                address: 'Rua do Catete, 300 - Rio de Janeiro/RJ',
                totalPurchases: 22,
                favoriteFood: 'Feijoada',
                lastOrder: 'Feijoada Completa (01/04/2025)',
                notes: []
            },
            { 
                id: 3, 
                name: 'Ana Santos', 
                situation: 200,
                fullName: 'Ana Clara Santos',
                nickname: 'Aninha',
                cpf: '789.123.456-00',
                email: 'ana@example.com',
                phone: '(31) 98765-1234',
                address: 'Av. Afonso Pena, 2000 - Belo Horizonte/MG',
                totalPurchases: 12,
                favoriteFood: 'Strogonoff',
                lastOrder: 'Strogonoff de Frango (30/03/2025)',
                notes: [
                    { text: "Aniversário em 15/05 - enviar cupom", time: "28/03/2025 14:20" }
                ]
            },
            { 
                id: 12, 
                name: 'Carlos Pereira', 
                situation: -80,
                fullName: 'Carlos Eduardo Pereira',
                nickname: 'Carlinhos',
                cpf: '321.654.987-00',
                email: 'carlos@example.com',
                phone: '(51) 91234-8765',
                address: 'Rua da Praia, 500 - Porto Alegre/RS',
                totalPurchases: 5,
                favoriteFood: 'Churrasco',
                lastOrder: 'Picanha (29/03/2025)',
                notes: []
            },
            { 
                id: 8, 
                name: 'Fernanda Lima', 
                situation: 75,
                fullName: 'Fernanda Lima Costa',
                nickname: 'Fê',
                cpf: '654.321.987-00',
                email: 'fernanda@example.com',
                phone: '(41) 99876-1234',
                address: 'Rua XV de Novembro, 100 - Curitiba/PR',
                totalPurchases: 18,
                favoriteFood: 'Sushi',
                lastOrder: 'Combo Sushi Variado (28/03/2025)',
                notes: [
                    { text: "Vegetariana - não enviar promoções de carne", time: "27/03/2025 09:45" }
                ]
            },
            { 
                id: 15, 
                name: 'Ricardo Almeida', 
                situation: -120,
                fullName: 'Ricardo José Almeida',
                nickname: 'Rick',
                cpf: '147.258.369-00',
                email: 'ricardo@example.com',
                phone: '(85) 98765-4321',
                address: 'Av. Beira Mar, 800 - Fortaleza/CE',
                totalPurchases: 7,
                favoriteFood: 'Moqueca',
                lastOrder: 'Moqueca de Camarão (27/03/2025)',
                notes: []
            },
            { 
                id: 4, 
                name: 'Juliana Costa', 
                situation: 50,
                fullName: 'Juliana Costa e Silva',
                nickname: 'Ju',
                cpf: '258.369.147-00',
                email: 'juliana@example.com',
                phone: '(71) 91234-5678',
                address: 'Rua Chile, 200 - Salvador/BA',
                totalPurchases: 10,
                favoriteFood: 'Acarajé',
                lastOrder: 'Acarajé com Camarão (26/03/2025)',
                notes: [
                    { text: "Pediu para não ligar após as 20h", time: "25/03/2025 16:30" }
                ]
            },
            { 
                id: 9, 
                name: 'Pedro Souza', 
                situation: 180,
                fullName: 'Pedro Henrique Souza',
                nickname: 'Pedrão',
                cpf: '369.147.258-00',
                email: 'pedro@example.com',
                phone: '(81) 99876-5432',
                address: 'Rua do Sol, 150 - Recife/PE',
                totalPurchases: 25,
                favoriteFood: 'Baião de Dois',
                lastOrder: 'Baião de Dois com Carne Seca (25/03/2025)',
                notes: []
            },
            { 
                id: 6, 
                name: 'Camila Rocha', 
                situation: -25,
                fullName: 'Camila Rocha Oliveira',
                nickname: 'Cami',
                cpf: '951.753.852-00',
                email: 'camila@example.com',
                phone: '(48) 98765-1234',
                address: 'Rua das Palmeiras, 350 - Florianópolis/SC',
                totalPurchases: 14,
                favoriteFood: 'Pastel',
                lastOrder: 'Pastel de Camarão (24/03/2025)',
                notes: [
                    { text: "Reclamou do último pedido - oferecer desconto na próxima", time: "23/03/2025 11:10" }
                ]
            }
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
        
        // Painéis laterais
        const detailsPanel = document.getElementById('detailsPanel');
        const notesPanel = document.getElementById('notesPanel');
        const closeDetails = document.getElementById('closeDetails');
        const closeNotes = document.getElementById('closeNotes');
        
        // Elementos de detalhes
        const detailsClientName = document.getElementById('detailsClientName');
        const detailFullName = document.getElementById('detailFullName');
        const detailNickname = document.getElementById('detailNickname');
        const detailCpf = document.getElementById('detailCpf');
        const detailEmail = document.getElementById('detailEmail');
        const detailPhone = document.getElementById('detailPhone');
        const detailAddress = document.getElementById('detailAddress');
        const detailBalance = document.getElementById('detailBalance');
        const detailTotalPurchases = document.getElementById('detailTotalPurchases');
        const detailFavoriteFood = document.getElementById('detailFavoriteFood');
        const detailLastOrder = document.getElementById('detailLastOrder');
        
        // Elementos de anotações
        const notesClientName = document.getElementById('notesClientName');
        const notesContent = document.getElementById('notesContent');
        const notesInput = document.getElementById('notesInput');
        const saveNote = document.getElementById('saveNote');
        
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
            const clientItem = e.target.closest('.client-card');
            if (!clientItem) return;
            
            currentClientId = parseInt(clientItem.getAttribute('data-id'));
            currentClientName = clientItem.getAttribute('data-name');
            const client = clients.find(c => c.id === currentClientId);
            
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
                loadClientDetails(client);
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
                renderNotes(client.notes);
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
                
                // Atualizar também nos painéis se estiverem abertos
                if (detailsPanel.classList.contains('active') && clients[clientIndex].id === currentClientId) {
                    detailsClientName.textContent = newName;
                    detailBalance.textContent = `R$ ${newSituation.toFixed(2)}`;
                    detailBalance.className = newSituation < 0 ? 'detail-value text-red-500' : 'detail-value';
                }
                
                if (notesPanel.classList.contains('active') && clients[clientIndex].id === currentClientId) {
                    notesClientName.textContent = newName;
                }
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
            
            const clientIndex = clients.findIndex(c => c.id === currentClientId);
            if (clientIndex !== -1) {
                clients[clientIndex].notes.unshift({
                    text: noteText,
                    time: timeString
                });
                
                renderNotes(clients[clientIndex].notes);
                notesInput.value = '';
            }
        });
        
        // Função para renderizar a lista de clientes
        function renderClientList(clientsToRender) {
            clientList.innerHTML = '';
            
            if (clientsToRender.length === 0) {
                clientList.innerHTML = '<div class="p-4 text-center text-gray-500 bg-white rounded-b-lg">Nenhum cliente encontrado</div>';
                return;
            }
            
            clientsToRender.forEach(client => {
                const situationClass = client.situation < 0 ? 'text-red-500 font-medium' : 'text-gray-800';
                const situationValue = client.situation < 0 ? `R$ ${client.situation.toFixed(2)}` : `R$ ${client.situation.toFixed(2)}`;
                
                const clientItem = document.createElement('div');
                clientItem.className = 'client-card grid grid-cols-12 gap-1 items-center p-3 hover:bg-gray-50 transition text-sm';
                clientItem.setAttribute('data-id', client.id);
                clientItem.setAttribute('data-name', client.name);
                clientItem.setAttribute('data-situation', client.situation);
                
                clientItem.innerHTML = `
                    <div class="col-span-3 name">${client.name}</div>
                    <div class="col-span-2 id">${client.id}</div>
                    <div class="col-span-2 situation ${situationClass}">${situationValue}</div>
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
                            <button class="delete-btn p-1 hover:bg-red-50 rounded transition ml-1">
                                <img src="{{ asset('Icons/trash-red.png') }}" alt="Excluir" class="icon-img">
                            </button>
                        </div>
                    </div>
                `;
                
                clientList.appendChild(clientItem);
            });
        }
        
        // Função para carregar detalhes do cliente
        function loadClientDetails(client) {
            detailsClientName.textContent = client.name;
            detailFullName.textContent = client.fullName;
            detailNickname.textContent = client.nickname;
            detailCpf.textContent = client.cpf;
            detailEmail.textContent = client.email;
            detailPhone.textContent = client.phone;
            detailAddress.textContent = client.address;
            detailBalance.textContent = `R$ ${client.situation.toFixed(2)}`;
            detailBalance.className = client.situation < 0 ? 'detail-value text-red-500' : 'detail-value';
            detailTotalPurchases.textContent = `${client.totalPurchases} compras`;
            detailFavoriteFood.textContent = client.favoriteFood;
            detailLastOrder.textContent = client.lastOrder;
        }
        
        // Função para renderizar as anotações
        function renderNotes(notes) {
            notesContent.innerHTML = '';
            
            if (notes.length === 0) {
                notesContent.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p>Nenhuma anotação encontrada</p>
                    </div>
                `;
                return;
            }
            
            notes.forEach(note => {
                const noteElement = document.createElement('div');
                noteElement.className = 'detail-item';
                noteElement.innerHTML = `
                    <div class="detail-label">${note.time}</div>
                    <div class="detail-value">${note.text}</div>
                `;
                notesContent.appendChild(noteElement);
            });
        }
    });
</script>

</body>
</html>