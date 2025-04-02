<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>
<body class="bg-gray-100 text-white">

<x-hotbar-admin />

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            500: '#FF7F00',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 shadow">
                <div class="flex items-center">
                    <div class="relative flex-1 max-w-md">
                        <input type="text" placeholder="Pesquisar clientes..." class="w-full pl-4 pr-10 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button class="absolute right-2 top-2 text-gray-500 hover:text-orange-500">
                            <img src="{{ asset('images/search.png') }}" alt="Search" class="h-5 w-5">
                        </button>
                    </div>
                    <div class="ml-4 relative">
                        <button id="filterToggle" class="flex items-center px-3 py-2 border rounded-lg hover:bg-gray-50">
                            <span>Filtrar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <div class="py-1">
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="name-asc">Nome (A-Z)</a>
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="name-desc">Nome (Z-A)</a>
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="id-asc">ID (Crescente)</a>
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="id-desc">ID (Decrescente)</a>
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="value-asc">Valor (Menor-Maior)</a>
                                <a href="#" class="filter-option block px-4 py-2 text-sm hover:bg-gray-100" data-sort="value-desc">Valor (Maior-Menor)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Table and Notes Section -->
            <div class="flex-1 flex overflow-hidden">
                <!-- Client Table -->
                <div class="w-1/2 bg-white overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Situação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dados</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anotações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="client-row hover:bg-gray-50 cursor-pointer" data-client-id="10">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">Apollo Henrique</div>
                                        <button class="ml-2 edit-btn">
                                            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="h-4 w-4">
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <span class="text-red-500">R$-43</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="data-btn">
                                        <img src="{{ asset('images/maximize.png') }}" alt="Data" class="h-5 w-5">
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="notes-btn">
                                        <img src="{{ asset('images/clipboard.png') }}" alt="Notes" class="h-5 w-5">
                                    </button>
                                </td>
                            </tr>
                            <!-- More client rows would go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Notes Panel (initially hidden) -->
                <div id="notesPanel" class="hidden w-1/2 bg-gray-50 border-l overflow-y-auto flex flex-col">
                    <div class="p-4 border-b">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Apollo Henrique</h3>
                            <span class="text-sm text-gray-500 flex items-center">
                                <img src="{{ asset('images/clock.png') }}" alt="Time" class="h-4 w-4 mr-1">
                                12:00
                                <span class="ml-1">😊</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex-1 overflow-y-auto">
                        <div class="mb-4">
                            <p class="bg-white p-3 rounded-lg shadow-sm">
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit"
                            </p>
                            <p class="text-xs text-gray-500 mt-1 text-right">12:00</p>
                        </div>
                        <div class="mb-4">
                            <p class="bg-white p-3 rounded-lg shadow-sm">
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit"
                            </p>
                            <p class="text-xs text-gray-500 mt-1 text-right">12:05</p>
                        </div>
                    </div>
                    <div class="p-4 border-t">
                        <form id="noteForm" class="flex">
                            <input type="text" placeholder="Digite uma anotação..." class="flex-1 border rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-r-lg hover:bg-orange-600">
                                Enviar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Editar Cliente</h3>
            <form id="editForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editName">
                        Nome
                    </label>
                    <input type="text" id="editName" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" value="Apollo Henrique">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editId">
                        ID
                    </label>
                    <input type="text" id="editId" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" value="10" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="editValue">
                        Valor
                    </label>
                    <input type="text" id="editValue" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" value="-43">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="deleteClient" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center">
                        <img src="{{ asset('images/trash-red.png') }}" alt="Delete" class="h-4 w-4 mr-2">
                        Excluir
                    </button>
                    <button type="button" id="cancelEdit" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Confirmar Exclusão</h3>
            <p class="mb-6">Tem certeza que deseja excluir este cliente e todas as suas informações?</p>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelDelete" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Cancelar
                </button>
                <button type="button" id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Excluir
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle filter dropdown
            const filterToggle = document.getElementById('filterToggle');
            const filterDropdown = document.getElementById('filterDropdown');
            
            filterToggle.addEventListener('click', function() {
                filterDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!filterToggle.contains(event.target) && !filterDropdown.contains(event.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });

            // Handle filter selection
            document.querySelectorAll('.filter-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortType = this.getAttribute('data-sort');
                    // Implement sorting logic here
                    console.log('Sort by:', sortType);
                    filterDropdown.classList.add('hidden');
                });
            });

            // Toggle notes panel
            const notesButtons = document.querySelectorAll('.notes-btn');
            const notesPanel = document.getElementById('notesPanel');
            
            notesButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Toggle orange color for active button
                    document.querySelectorAll('.notes-btn').forEach(btn => {
                        btn.querySelector('img').classList.remove('filter', 'brightness-0', 'invert-1');
                    });
                    this.querySelector('img').classList.add('filter', 'brightness-0', 'invert-1');
                    
                    // Show notes panel
                    notesPanel.classList.remove('hidden');
                });
            });

            // Handle note submission
            const noteForm = document.getElementById('noteForm');
            noteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const input = this.querySelector('input');
                const noteText = input.value.trim();
                
                if (noteText) {
                    const now = new Date();
                    const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
                    
                    const notesContainer = notesPanel.querySelector('.flex-1');
                    const newNote = document.createElement('div');
                    newNote.className = 'mb-4';
                    newNote.innerHTML = `
                        <p class="bg-white p-3 rounded-lg shadow-sm">${noteText}</p>
                        <p class="text-xs text-gray-500 mt-1 text-right">${timeString}</p>
                    `;
                    
                    notesContainer.appendChild(newNote);
                    input.value = '';
                    notesContainer.scrollTop = notesContainer.scrollHeight;
                }
            });

            // Edit client modal
            const editButtons = document.querySelectorAll('.edit-btn');
            const editModal = document.getElementById('editModal');
            const cancelEdit = document.getElementById('cancelEdit');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    editModal.classList.remove('hidden');
                });
            });
            
            cancelEdit.addEventListener('click', function() {
                editModal.classList.add('hidden');
            });

            // Delete confirmation modal
            const deleteClient = document.getElementById('deleteClient');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const confirmDelete = document.getElementById('confirmDelete');
            
            deleteClient.addEventListener('click', function() {
                editModal.classList.add('hidden');
                deleteModal.classList.remove('hidden');
            });
            
            cancelDelete.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
            });
            
            confirmDelete.addEventListener('click', function() {
                // Implement delete logic here
                console.log('Client deleted');
                deleteModal.classList.add('hidden');
            });

            // Handle value color based on sign
            const editValue = document.getElementById('editValue');
            editValue.addEventListener('input', function() {
                const valueCell = document.querySelector('.client-row[data-client-id="10"] td:nth-child(3) span');
                if (this.value.startsWith('-')) {
                    valueCell.classList.add('text-red-500');
                    valueCell.classList.remove('text-gray-900');
                } else {
                    valueCell.classList.remove('text-red-500');
                    valueCell.classList.add('text-gray-900');
                }
            });

            // Handle form submission
            const editForm = document.getElementById('editForm');
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const name = document.getElementById('editName').value;
                const id = document.getElementById('editId').value;
                const value = document.getElementById('editValue').value;
                
                // Update the table row
                const clientRow = document.querySelector(`.client-row[data-client-id="${id}"]`);
                clientRow.querySelector('td:nth-child(1) .text-sm').textContent = name;
                clientRow.querySelector('td:nth-child(3) span').textContent = `R$${value}`;
                
                if (value.startsWith('-')) {
                    clientRow.querySelector('td:nth-child(3) span').classList.add('text-red-500');
                    clientRow.querySelector('td:nth-child(3) span').classList.remove('text-gray-900');
                } else {
                    clientRow.querySelector('td:nth-child(3) span').classList.remove('text-red-500');
                    clientRow.querySelector('td:nth-child(3) span').classList.add('text-gray-900');
                }
                
                editModal.classList.add('hidden');
            });

            // Make responsive
            function handleResize() {
                if (window.innerWidth < 768) {
                    notesPanel.classList.add('absolute', 'inset-0', 'z-40', 'bg-white');
                    notesPanel.classList.remove('w-1/2');
                } else {
                    notesPanel.classList.remove('absolute', 'inset-0', 'z-40', 'bg-white');
                    notesPanel.classList.add('w-1/2');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize();
        });
    </script>
</body>
</html>