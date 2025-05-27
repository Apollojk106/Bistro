<div class="min-h-screen bg-gray-50">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-hotbar-admin />

    <div class="container mx-auto px-4 py-6">
       

        <!-- Search and Actions -->
        <div class="flex flex-col lg:flex-row gap-6 mb-6">
            <!-- Search Bar -->
            <div class="flex-1 bg-white rounded-xl shadow-md p-4 transition-all duration-300 hover:shadow-lg">
                <form action="{{ route('Cardapio.Filtro') }}" method="post" class="flex items-center gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <select id="categoria" name="categoria" class="appearance-none bg-gray-100 border-0 rounded-lg py-2 pl-10 pr-8 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="nome">Nome</option>
                            <option value="id_categoria">Categoria</option>
                            <option value="valor">Valor</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <input id="conteudo" name="conteudo" type="text" placeholder="Pesquisar..." class="flex-1 bg-gray-100 border-0 rounded-lg py-2 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200" />
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg flex items-center justify-center transition duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Desktop Actions -->
            <div class="hidden lg:flex items-center gap-3">
                <button onclick="window.location.href='/admin/Cardapio'" class="p-3 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <div class="flex gap-2 bg-white rounded-xl shadow-md p-2">
                    <button id="eye-on" class="p-2 rounded-lg hover:bg-blue-50 text-blue-500 transition duration-200 transform hover:scale-105 tooltip" data-tooltip="Mostrar itens">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                    <button id="eye-off" class="p-2 rounded-lg hover:bg-blue-50 text-blue-500 transition duration-200 transform hover:scale-105 tooltip" data-tooltip="Ocultar itens">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                    <button id="delete-selected" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition duration-200 transform hover:scale-105 tooltip" data-tooltip="Deletar selecionados">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <a href="{{ route('ItemCardapio') }}" class="p-2 rounded-lg hover:bg-green-50 text-green-500 transition duration-200 transform hover:scale-105 tooltip" data-tooltip="Adicionar item">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($Items as $Item)
                        <form action="{{ route('EditItemCardapio') }}" method="Post">
                            @csrf
                            <input type="hidden" name="Id" value="{{ $Item->id }}">
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $Item->nome }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $Item->categoria }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">R$ {{ number_format($Item->valor, 2, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 transition duration-200 transform hover:scale-110 tooltip" data-tooltip="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="text-red-600 hover:text-red-900 transition duration-200 transform hover:scale-110 delete-button tooltip" data-id="{{ $Item->id }}" data-tooltip="Deletar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="select-button text-gray-600 hover:text-yellow-600 transition duration-200 transform hover:scale-110 tooltip" data-id="{{ $Item->id }}" data-tooltip="Selecionar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-50">
        <div class="flex justify-around py-3">
            <button id="mobile-eye-on" class="p-2 text-blue-500 hover:text-blue-700 transition duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
            <button id="mobile-eye-off" class="p-2 text-blue-500 hover:text-blue-700 transition duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                </svg>
            </button>
            <button id="mobile-delete-selected" class="p-2 text-red-500 hover:text-red-700 transition duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
            <a href="{{ route('ItemCardapio') }}" class="p-2 text-green-500 hover:text-green-700 transition duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </a>
            <button onclick="window.location.href='/admin/Cardapio'" class="p-2 text-gray-500 hover:text-gray-700 transition duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>
    </div>

    <style>
        /* Tooltip styles */
        .tooltip {
            position: relative;
        }
        
        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
        }
        
        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
        }
        
        /* Animation for table rows */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        tbody tr {
            animation: fadeIn 0.3s ease-out forwards;
            opacity: 0;
        }
        
        tbody tr:nth-child(1) { animation-delay: 0.05s; }
        tbody tr:nth-child(2) { animation-delay: 0.1s; }
        tbody tr:nth-child(3) { animation-delay: 0.15s; }
        tbody tr:nth-child(4) { animation-delay: 0.2s; }
        tbody tr:nth-child(5) { animation-delay: 0.25s; }
        tbody tr:nth-child(6) { animation-delay: 0.3s; }
        tbody tr:nth-child(7) { animation-delay: 0.35s; }
        tbody tr:nth-child(8) { animation-delay: 0.4s; }
        tbody tr:nth-child(9) { animation-delay: 0.45s; }
        tbody tr:nth-child(10) { animation-delay: 0.5s; }
        
        /* Selected item style */
        .select-button.selected {
            color: #F59E0B;
        }
    </style>

    <script>
        // Array para armazenar os itens selecionados
        let selectedItems = [];

        // Função para alternar seleção
        function toggleItemSelection(itemId) {
            const index = selectedItems.indexOf(itemId);
            if (index === -1) {
                selectedItems.push(itemId);
            } else {
                selectedItems.splice(index, 1);
            }
            updateSelectedButtons(itemId);
            
            // Feedback visual
            if (selectedItems.length > 0) {
                document.querySelectorAll('.delete-button, #delete-selected, #mobile-delete-selected').forEach(btn => {
                    btn.classList.add('animate-pulse');
                    setTimeout(() => btn.classList.remove('animate-pulse'), 1000);
                });
            }
        }

        // Atualizar visual dos botões de seleção
        function updateSelectedButtons(itemId) {
            const buttons = document.querySelectorAll(`.select-button[data-id="${itemId}"]`);
            buttons.forEach(button => {
                button.classList.toggle('selected', selectedItems.includes(itemId));
            });
        }

        // Configurar eventos de clique para os botões de seleção
        document.querySelectorAll('.select-button').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                toggleItemSelection(itemId);
            });
        });

        // Função para enviar formulário de visibilidade
        function enviarFormularioDeVisibilidade(rota) {
            if (selectedItems.length === 0) {
                showAlert('Por favor, selecione pelo menos um item', 'warning');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = rota;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfToken);

            selectedItems.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // Configurar botões desktop
        document.getElementById('eye-on').addEventListener('click', () => enviarFormularioDeVisibilidade('/eye-on'));
        document.getElementById('eye-off').addEventListener('click', () => enviarFormularioDeVisibilidade('/eye-off'));
        document.getElementById('delete-selected').addEventListener('click', deletarSelecionados);

        // Configurar botões mobile
        document.getElementById('mobile-eye-on').addEventListener('click', () => enviarFormularioDeVisibilidade('/eye-on'));
        document.getElementById('mobile-eye-off').addEventListener('click', () => enviarFormularioDeVisibilidade('/eye-off'));
        document.getElementById('mobile-delete-selected').addEventListener('click', deletarSelecionados);

        // Função para deletar itens selecionados
        function deletarSelecionados() {
            if (selectedItems.length === 0) {
                showAlert('Por favor, selecione pelo menos um item', 'warning');
                return;
            }

            Swal.fire({
                title: 'Tem certeza?',
                text: `Você está prestes a deletar ${selectedItems.length} item(ns) selecionado(s).`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/Cardapio/DeleteMultiple';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrfToken);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    selectedItems.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Configurar botões de delete individuais
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/Cardapio/Delete${itemId}`;
                    }
                });
            });
        });

        // Função para mostrar alertas bonitos
        function showAlert(message, type = 'info') {
            const colors = {
                info: 'blue',
                success: 'green',
                warning: 'yellow',
                error: 'red'
            };
            
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: `var(--${colors[type]}-500)`,
                stopOnFocus: true,
            }).showToast();
        }
    </script>

    <!-- Adicionando SweetAlert2 para diálogos bonitos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</div>