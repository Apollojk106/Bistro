<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <x-hotbar-admin />

    <form action="{{ route('SaveItem') }}" enctype="multipart/form-data" method="post" class="animate-fade-in">
        @csrf
        <div class="container mx-auto p-4 lg:p-6">
           
            <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Corrija os seguintes erros:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Nome" class="block text-sm font-medium text-gray-700 mb-2">Nome do Item</label>
                        <input id="Nome" name="Nome" type="text" value="{{ isset($Item) ? $Item->nome : old('Nome') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="Ex: Pizza Margherita">
                    </div>

                    <!-- Image Upload -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagem do Item</label>
                        
                        <!-- Current Image Preview -->
                        @if(isset($Item) && $Item->imagem)
                        <div class="mb-4 flex flex-col items-center">
                            <div class="relative group">
                                <img src="{{ asset($Item->imagem) }}" alt="{{ $Item->nome }}" 
                                     class="w-40 h-40 object-cover rounded-lg shadow-md group-hover:opacity-75 transition duration-200">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                    <span class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">Imagem Atual</span>
                                </div>
                            </div>
                            <span class="mt-2 text-xs text-gray-500">Clique abaixo para alterar</span>
                        </div>
                        @endif

                        <!-- File Input -->
                        <div class="flex items-center justify-center w-full">
                            <label for="Imagem" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Clique para enviar</span> ou arraste e solte
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 5MB)</p>
                                </div>
                                <input id="Imagem" name="Imagem" type="file" accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-4">
                    <!-- Valor -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Valor" class="block text-sm font-medium text-gray-700 mb-2">Valor (R$)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">R$</span>
                            </div>
                            <input id="Valor" name="Valor" type="text" value="{{ isset($Item) ? $Item->valor : old('Valor') }}" 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   placeholder="0,00">
                        </div>
                    </div>

                    <!-- Categoria -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                        <select id="categoria" name="categoria" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                onchange="handleCategoryChange(this)">
                            <option value="{{ isset($Item) ? $Item->id_categoria : '' }}" selected>
                                {{ isset($Item) ? $Item->categoria : 'Selecione uma categoria' }}
                            </option>
                            
                            @foreach($Categorias as $id => $nome)
                            <option value="{{ $id }}" {{ old('categoria') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                            @endforeach
                            
                            <option value="novo">➕ Adicionar Nova Categoria</option>
                        </select>

                        <!-- New Category Input (hidden by default) -->
                        <div id="newcategory-container" class="mt-4 hidden transition-all duration-300 ease-in-out">
                            <label for="newcategory" class="block text-sm font-medium text-gray-700 mb-2">Nome da Nova Categoria</label>
                            <input type="text" id="newcategory" name="newcategory" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   placeholder="Ex: Bebidas Premium" value="{{ old('newcategory') }}">
                        </div>
                    </div>

                    <!-- Ingredientes -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Igredientes" class="block text-sm font-medium text-gray-700 mb-2">Ingredientes</label>
                        <textarea id="Igredientes" name="Igredientes" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="Liste os ingredientes separados por vírgula">{{ isset($Item) ? $Item->ingredientes : old('Igredientes') }}</textarea>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="space-y-4">
                    <!-- Descrição -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                        <textarea id="Descricao" name="Descricao" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="Descreva o item detalhadamente">{{ isset($Item) ? $Item->descricao : old('Descricao') }}</textarea>
                    </div>

                    <!-- Desconto -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Desconto" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                        <input id="Desconto" name="Desconto" type="number" min="0" max="100" 
                               value="{{ isset($Item) ? $Item->desconto : (old('Desconto') ?? '0') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               placeholder="0">
                    </div>

                    <!-- Disponibilidade -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Disponibilidade" class="block text-sm font-medium text-gray-700 mb-2">Disponibilidade</label>
                        <select id="Disponibilidade" name="Disponibilidade" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="Todo dia" {{ (isset($Item) && $Item->disponibilidade == 'Todo dia') || old('Disponibilidade') == 'Todo dia' ? 'selected' : '' }}>Todo dia</option>
                            <option value="Apenas almoço" {{ (isset($Item) && $Item->disponibilidade == 'Apenas almoço') || old('Disponibilidade') == 'Apenas almoço' ? 'selected' : '' }}>Apenas almoço</option>
                            <option value="Apenas jantar" {{ (isset($Item) && $Item->disponibilidade == 'Apenas jantar') || old('Disponibilidade') == 'Apenas jantar' ? 'selected' : '' }}>Apenas jantar</option>
                            <option value="Sob encomenda" {{ (isset($Item) && $Item->disponibilidade == 'Sob encomenda') || old('Disponibilidade') == 'Sob encomenda' ? 'selected' : '' }}>Sob encomenda</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <button type="submit" 
                                class="flex-1 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Salvar Item
                        </button>
                        
                        <a href="/admin/Cardapio/" 
                           class="flex-1 flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    /* File upload hover effect */
    [type="file"] + label:hover {
        background-color: #f3f4f6;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<script>
    // Função para alternar entre o select e o campo de input
    function handleCategoryChange(selectElement) {
        const newCategoryContainer = document.getElementById('newcategory-container');
        
        if (selectElement.value === "novo") {
            newCategoryContainer.classList.remove('hidden');
            newCategoryContainer.classList.add('block');
            
            // Anime.js animation for smooth appearance
            anime({
                targets: '#newcategory-container',
                opacity: [0, 1],
                translateY: [-10, 0],
                duration: 300,
                easing: 'easeOutQuad'
            });
        } else {
            // Anime.js animation for smooth disappearance
            anime({
                targets: '#newcategory-container',
                opacity: [1, 0],
                translateY: [0, -10],
                duration: 200,
                easing: 'easeInQuad',
                complete: function() {
                    newCategoryContainer.classList.remove('block');
                    newCategoryContainer.classList.add('hidden');
                }
            });
        }
    }

    // Preview image when selected
    document.getElementById('Imagem').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                // Create or update preview image
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mb-4 flex flex-col items-center';
                    e.target.parentNode.insertBefore(preview, e.target.nextSibling);
                }
                
                preview.innerHTML = `
                    <div class="relative group">
                        <img src="${event.target.result}" alt="Preview" 
                             class="w-40 h-40 object-cover rounded-lg shadow-md group-hover:opacity-75 transition duration-200">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">Nova Imagem</span>
                        </div>
                    </div>
                    <span class="mt-2 text-xs text-gray-500">Pré-visualização</span>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Format currency input
    document.getElementById('Valor').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2) + '';
        value = value.replace(".", ",");
        value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        
        if (value === '0,00') {
            e.target.value = '';
        } else {
            e.target.value = value;
        }
    });
</script>