<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <style>
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* File upload hover effect */
        [type="file"]+label:hover {
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

        /* Custom checkbox styles */
        .day-checkbox-card {
            transition: all 0.3s ease;
        }

        .day-checkbox-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .day-checkbox-card:has(input:checked) {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        /* Loading animation */
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <x-hotbar-admin />

    <form action="{{ route('SaveItem') }}" enctype="multipart/form-data" method="post" class="animate-fade-in" id="itemForm">
        @csrf
        <div class="container mx-auto p-4 lg:p-6">



            <!-- Form Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Nome" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome do Item <span class="text-red-500">*</span>
                        </label>
                        <input id="Nome" name="Nome" type="text" value="{{ isset($Item) ? $Item->nome : old('Nome') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Ex: Pizza Margherita"
                            required>
                    </div>

                    <!-- Categoria -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select id="categoria" name="categoria"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            onchange="handleCategoryChange(this)"
                            required>
                            <option value="" disabled {{ !isset($Item) && !old('categoria') ? 'selected' : '' }}>Selecione uma categoria</option>

                            @if(isset($Item))
                            <option value="{{ $Item->id_categoria }}" selected>
                                {{ $Item->categoria }}
                            </option>
                            @endif

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

                        <!-- Image Preview Container -->
                        <div id="image-preview-container" class="mt-4 hidden">
                            <!-- Preview will be inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-4">
                    <!-- Valor -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Valor" class="block text-sm font-medium text-gray-700 mb-2">
                            Valor (R$) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">R$</span>
                            </div>
                            <input id="Valor" name="Valor" type="text" value="{{ isset($Item) ? $Item->valor : old('Valor') }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="0,00"
                                required>
                        </div>
                    </div>

                    <!-- Desconto -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label for="Desconto" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                        <div class="relative">
                            <input id="Desconto" name="Desconto" type="number" min="0" max="100"
                                value="{{ isset($Item) ? $Item->desconto : (old('Desconto') ?? '0') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Deixe em 0 para não aplicar desconto</p>
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
                        <label for="Descricao" class="block text-sm font-medium text-gray-700 mb-2">
                            Descrição <span class="text-red-500">*</span>
                        </label>
                        <textarea id="Descricao" name="Descricao" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Descreva o item detalhadamente"
                            required>{{ isset($Item) ? $Item->descricao : old('Descricao') }}</textarea>
                    </div>

                    <!-- Disponibilidade - NOVA VERSÃO -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition duration-300">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Disponibilidade</label>

                        <!-- Opção "Todos os Dias" -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center">
                                <input type="checkbox" id="todos-dias" name="disponibilidade_todos" value="1"
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer transition duration-200"
                                    onchange="toggleAllDays(this)"
                                    {{ isset($Item) && count($Item->disponibilidade) === 7 ? 'checked' : '' }}>
                                <label for="todos-dias" class="ml-3 flex items-center cursor-pointer">
                                    <span class="text-gray-700 font-medium text-sm">Todos os dias (Segunda a Domingo)</span>
                                    <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">Recomendado</span>
                                </label>
                            </div>
                            <p class="text-gray-500 text-xs mt-2 ml-8">Marque esta opção para disponibilidade em todos os dias da semana</p>
                        </div>

                        <!-- Dias da Semana -->
                        <div class="space-y-3">
                            <p class="text-sm font-medium text-gray-700 mb-3">Selecione os dias específicos:</p>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-3">
                                <!-- Segunda-feira -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="segunda" name="disponibilidade_dias[]" value="segunda"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(1, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="segunda"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">SEG</span>
                                        <span class="text-xs text-gray-500 mt-1">Segunda</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Terça-feira -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="terca" name="disponibilidade_dias[]" value="terca"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(2, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="terca"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">TER</span>
                                        <span class="text-xs text-gray-500 mt-1">Terça</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Quarta-feira -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="quarta" name="disponibilidade_dias[]" value="quarta"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(3, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="quarta"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">QUA</span>
                                        <span class="text-xs text-gray-500 mt-1">Quarta</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Quinta-feira -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="quinta" name="disponibilidade_dias[]" value="quinta"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(4, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="quinta"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">QUI</span>
                                        <span class="text-xs text-gray-500 mt-1">Quinta</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Sexta-feira -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="sexta" name="disponibilidade_dias[]" value="sexta"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(5, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="sexta"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">SEX</span>
                                        <span class="text-xs text-gray-500 mt-1">Sexta</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Sábado -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="sabado" name="disponibilidade_dias[]" value="sabado"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(6, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="sabado"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">SÁB</span>
                                        <span class="text-xs text-gray-500 mt-1">Sábado</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>

                                <!-- Domingo -->
                                <div class="relative day-checkbox-card">
                                    <input type="checkbox" id="domingo" name="disponibilidade_dias[]" value="domingo"
                                        class="peer hidden"
                                        {{ isset($Item) && in_array(7, $Item->disponibilidade) ? 'checked' : '' }}>
                                    <label for="domingo"
                                        class="flex flex-col items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                        <span class="text-lg font-semibold text-gray-700 peer-checked:text-blue-700">DOM</span>
                                        <span class="text-xs text-gray-500 mt-1">Domingo</span>
                                        <svg class="absolute top-2 right-2 w-4 h-4 text-blue-500 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span id="submit-text">Salvar Item</span>
                            <div id="submit-loading" class="loading-spinner hidden"></div>
                        </button>

                        <a href="/admin/Cardapio/"
                            class="flex-1 flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
                // Validação do tamanho do arquivo (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('O arquivo é muito grande. O tamanho máximo é 5MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    // Remove preview anterior se existir
                    let existingPreview = document.getElementById('image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Cria nova preview
                    const previewContainer = document.getElementById('image-preview-container');
                    previewContainer.innerHTML = `
                        <div id="image-preview" class="flex flex-col items-center">
                            <div class="relative group mb-4">
                                <img src="${event.target.result}" alt="Preview" 
                                     class="w-40 h-40 object-cover rounded-lg shadow-md group-hover:opacity-75 transition duration-200">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                    <span class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">Pré-visualização</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">Clique no campo acima para alterar</span>
                        </div>
                    `;
                    previewContainer.classList.remove('hidden');

                    // Anima a entrada
                    anime({
                        targets: '#image-preview',
                        opacity: [0, 1],
                        scale: [0.9, 1],
                        duration: 300,
                        easing: 'easeOutBack'
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Format currency input
        document.getElementById('Valor').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2);
            value = value.replace(".", ",");
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            if (value === '0,00') {
                e.target.value = '';
            } else {
                e.target.value = value;
            }
        });

        // Form submission loading state
        document.getElementById('itemForm').addEventListener('submit', function(e) {
            // Validação básica
            const nome = document.getElementById('Nome').value.trim();
            const valor = document.getElementById('Valor').value.trim();
            const categoria = document.getElementById('categoria').value;
            const descricao = document.getElementById('Descricao').value.trim();

            if (!nome || !valor || !categoria || !descricao) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios (*)');
                return;
            }

            // Mostra loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
            submitBtn.disabled = true;

            // Remove loading após 10 segundos (fallback)
            setTimeout(() => {
                submitText.classList.remove('hidden');
                submitLoading.classList.add('hidden');
                submitBtn.disabled = false;
            }, 10000);
        });

        // Função para "Todos os dias" - AGORA INCLUINDO SÁBADO E DOMINGO
        function toggleAllDays(checkbox) {
            const todosDias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];

            if (checkbox.checked) {
                // Marca todos os 7 dias da semana
                todosDias.forEach(dia => {
                    const diaCheckbox = document.getElementById(dia);
                    if (diaCheckbox) {
                        diaCheckbox.checked = true;
                        // Trigger change event para atualizar visual
                        diaCheckbox.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                });

                // Anima a seleção
                anime({
                    targets: todosDias.map(dia => `#${dia}`).join(', '),
                    scale: [0.9, 1],
                    duration: 300,
                    delay: anime.stagger(50),
                    easing: 'easeOutBack'
                });
            } else {
                // Remove marcação de todos os dias
                todosDias.forEach(dia => {
                    const diaCheckbox = document.getElementById(dia);
                    if (diaCheckbox) {
                        diaCheckbox.checked = false;
                        diaCheckbox.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                });
            }
        }

        // Verifica se todos os 7 dias estão marcados e atualiza o checkbox "Todos os dias"
        function checkAllDays() {
            const todosDias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];
            const todosMarcados = todosDias.every(dia => {
                const checkbox = document.getElementById(dia);
                return checkbox && checkbox.checked;
            });

            const todosDiasCheckbox = document.getElementById('todos-dias');
            if (todosDiasCheckbox) {
                todosDiasCheckbox.checked = todosMarcados;
            }
        }

        // Adiciona eventos aos checkboxes dos dias
        document.querySelectorAll('input[name="disponibilidade_dias[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                checkAllDays();

                // Anima o card quando selecionado
                const card = this.closest('.day-checkbox-card');
                if (card) {
                    anime({
                        targets: card,
                        scale: [1, 1.05, 1],
                        duration: 300,
                        easing: 'easeOutBack'
                    });
                }
            });
        });

        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            // Verifica se todos os dias já estão marcados ao carregar a página
            checkAllDays();

            // Converte disponibilidade antiga para o novo formato
            const oldDisponibilidade = @json($Item->disponibilidade ?? []);
            if (oldDisponibilidade) {
                if (oldDisponibilidade === 'Todo dia') {
                    document.getElementById('todos-dias').checked = true;
                    toggleAllDays(document.getElementById('todos-dias'));
                }
            }

            // Converte período antigo para o novo formato
            const oldPeriodo = "{{ isset($Item) ? $Item->disponibilidade_periodo : '' }}";
            if (oldPeriodo) {
                if (oldPeriodo.includes('almoço')) {
                    document.getElementById('almoco').checked = true;
                }
                if (oldPeriodo.includes('jantar')) {
                    document.getElementById('jantar').checked = true;
                }
                if (oldPeriodo.includes('sob_encomenda')) {
                    document.getElementById('sob-encomenda').checked = true;
                }
            }

            // Anima a entrada dos elementos
            anime({
                targets: '.bg-white',
                opacity: [0, 1],
                translateY: [20, 0],
                delay: anime.stagger(100),
                duration: 500,
                easing: 'easeOutQuad'
            });
        });
    </script>
</body>

</html>