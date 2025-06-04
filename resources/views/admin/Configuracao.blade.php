<div class="min-h-screen bg-gray-50">
    <x-hotbar-admin />

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Configurações Gerais -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Configurações Gerais</h2>
            </div>
            
            <form action="{{ route('admin.configuracao.update') }}" method="post" class="p-6">
                @csrf
                
                <div class="space-y-4">
                    @foreach($Configuracoes as $config)
                    <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">

                    @if($config->type == '1')
                    <div class="flex flex-col md:flex-row items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium mb-2 md:mb-0">{{$config->nome}}</span>
                        <select name="configs[{{ $config->id }}][status]" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="1" {{ $config->status ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ !$config->status ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    @elseif($config->type == '2')
                    <div class="flex flex-col md:flex-row items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                        <span class="text-gray-700 font-medium mb-2 md:mb-0">{{$config->nome}}</span>
                        <input type="text" name="configs[{{ $config->id }}][valores1]" 
                               value="{{ $config->valores1 ?? '' }}" 
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full md:w-64">
                    </div>
                    @elseif($config->type == '3')
                    <div class="flex flex-col md:flex-row items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium mb-2 md:mb-0">{{$config->nome}}</span>
                        <div class="flex items-center space-x-2 w-full md:w-auto">
                            <input type="text" name="configs[{{ $config->id }}][valores1]" 
                                   value="{{ $config->valores1 ?? '' }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 flex-1">
                            <span class="text-gray-500">às</span>
                            <input type="text" name="configs[{{ $config->id }}][valores2]" 
                                   value="{{ $config->valores2 ?? '' }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 flex-1">
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" 
                            class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-md transition duration-200 flex items-center space-x-2">
                        <span>Aplicar Alterações</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Formas de Pagamento -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Formas de Pagamento</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.configuracao.forma-pagamento') }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxa (%)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($FormaPagamentos as $Form)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="forma[{{$Form->id}}][nome]" 
                                               value="{{$Form->nome}}" 
                                               class="px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 w-full">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="forma[{{$Form->id}}][taxa]" 
                                               value="{{$Form->taxa}}" 
                                               class="px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 w-20">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button type="submit" name="action" value="edit" 
                                                class="text-orange-600 hover:text-orange-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button type="submit" name="action" value="delete{{$Form->id}}" 
                                                class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="forma[new][nome]" 
                                               value="Cartão" 
                                               class="px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 w-full">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="forma[new][taxa]" 
                                               value="2" 
                                               class="px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 w-20">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button type="submit" name="action" value="add" 
                                                class="text-green-600 hover:text-green-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <!-- Estrutura de Recomendados por Categoria -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Estrutura de Recomendados por Categoria</h2>
                <p class="text-orange-100 mt-1">Primária > Secundária > Terciária</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($Categorias as $nivel => $categoriasNivel)
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <div class="bg-orange-500 px-4 py-3">
                            <h3 class="text-lg font-medium text-white text-center">
                                @if($nivel == 'Primaria') Primária
                                @elseif($nivel == 'Secundária') Secundária
                                @elseif($nivel == 'Terciária') Terciária
                                @endif
                            </h3>
                        </div>
                        
                        <div class="p-4 space-y-3">
                            @foreach($categoriasNivel as $categoria)
                            <div class="bg-white p-3 rounded-lg shadow-sm">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-700">{{ $categoria->nome }}</span>
                                    
                                    <form action="{{ route('admin.configuracao.categoria.update', $categoria->id) }}" method="post" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        
                                        <select name="nivel" 
                                                class="px-2 py-1 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 text-sm">
                                            <option value="Primaria" {{ $categoria->nivel == 'Primaria' ? 'selected' : '' }}>Primária</option>
                                            <option value="Secundária" {{ $categoria->nivel == 'Secundária' ? 'selected' : '' }}>Secundária</option>
                                            <option value="Terciária" {{ $categoria->nivel == 'Terciária' ? 'selected' : '' }}>Terciária</option>
                                        </select>
                                        
                                        <button type="submit" 
                                                class="text-orange-600 hover:text-orange-800 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>