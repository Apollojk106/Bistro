<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Bistrô Terraço</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Estilos personalizados */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .gradient-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        .gradient-primary-hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
            border-color: #f97316;
        }
        
        /* Animação de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Progress steps */
        .step-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        
        .step-item:not(:last-child):after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: #e5e7eb;
            top: 15px;
            left: 50%;
            z-index: 1;
        }
        
        .step-item.active:not(:last-child):after {
            background: #f97316;
        }
        
        .step-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .step-item.active .step-icon {
            background: #f97316;
            color: white;
            transform: scale(1.1);
        }
        
        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak {
            background: #ef4444;
            width: 25%;
        }
        
        .strength-medium {
            background: #f59e0b;
            width: 50%;
        }
        
        .strength-good {
            background: #10b981;
            width: 75%;
        }
        
        .strength-strong {
            background: #10b981;
            width: 100%;
        }
        
        /* Custom checkbox */
        .custom-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }
        
        .custom-checkbox:checked {
            background-color: #f97316;
            border-color: #f97316;
        }
        
        .custom-checkbox:checked::after {
            content: "✓";
            position: absolute;
            color: white;
            font-size: 14px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        /* Mostrar/esconder senha */
        .password-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .password-toggle:hover {
            color: #f97316;
        }
        
        /* Auto-complete estilizado */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #f8fafc inset !important;
            -webkit-text-fill-color: #374151 !important;
        }
        
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen">
    <x-hotbar-user />
    
    <!-- Container principal -->
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Crie sua conta</h1>
            <p class="text-gray-600">Junte-se ao Bistrô Terraço e faça seus pedidos online</p>
        </div>

        <!-- Progress steps -->
        <div class="w-full max-w-2xl mb-8 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex justify-between mb-4">
                <div class="step-item active">
                    <div class="step-icon">
                        <i class="ph ph-user text-sm"></i>
                    </div>
                    <span class="text-xs font-medium mt-2 text-orange-600">Dados Pessoais</span>
                </div>
                <div class="step-item">
                    <div class="step-icon">
                        <i class="ph ph-map-pin text-sm"></i>
                    </div>
                    <span class="text-xs font-medium mt-2 text-gray-500">Endereço</span>
                </div>
                <div class="step-item">
                    <div class="step-icon">
                        <i class="ph ph-lock text-sm"></i>
                    </div>
                    <span class="text-xs font-medium mt-2 text-gray-500">Senha</span>
                </div>
            </div>
        </div>

        <!-- Card do formulário -->
        <div class="w-full max-w-2xl animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header do card -->
                <div class="gradient-primary text-white py-6 px-8 text-center">
                    <h2 class="text-2xl font-bold">Informações de cadastro</h2>
                    <p class="text-orange-100 mt-1">Preencha todos os campos obrigatórios</p>
                </div>
                
                <!-- Formulário -->
                <form class="p-8" action="{{ route('User.Cadastro.Post') }}" method="POST" id="cadastroForm">
                    @csrf
                    
                    <!-- Mensagens de erro -->
                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Grid de campos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Email -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-envelope-simple text-gray-400 mr-2"></i>
                                    E-mail *
                                </span>
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   placeholder="seu@email.com" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="email">
                        </div>
                        
                        <!-- Nome -->
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-user text-gray-400 mr-2"></i>
                                    Nome completo *
                                </span>
                            </label>
                            <input id="nome" 
                                   name="nome" 
                                   type="text" 
                                   placeholder="Seu nome completo" 
                                   value="{{ old('nome') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="name">
                        </div>
                        
                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-phone text-gray-400 mr-2"></i>
                                    Telefone *
                                </span>
                            </label>
                            <input id="telefone" 
                                   name="telefone" 
                                   type="tel" 
                                   placeholder="(11) 99999-9999" 
                                   value="{{ old('telefone') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="tel">
                        </div>
                        
                        <!-- CEP -->
                        <div>
                            <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-map-pin text-gray-400 mr-2"></i>
                                    CEP *
                                </span>
                            </label>
                            <div class="relative">
                                <input id="cep" 
                                       name="cep" 
                                       type="text" 
                                       placeholder="00000-000" 
                                       value="{{ old('cep') }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                       required>
                                <button type="button" 
                                        id="buscarCep" 
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-sm text-orange-500 hover:text-orange-600 font-medium">
                                    Buscar
                                </button>
                            </div>
                        </div>
                        
                        <!-- Rua -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="rua" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-road-horizon text-gray-400 mr-2"></i>
                                    Rua *
                                </span>
                            </label>
                            <input id="rua" 
                                   name="rua" 
                                   type="text" 
                                   placeholder="Nome da rua" 
                                   value="{{ old('rua') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required>
                        </div>
                        
                        <!-- Bairro -->
                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-buildings text-gray-400 mr-2"></i>
                                    Bairro *
                                </span>
                            </label>
                            <input id="bairro" 
                                   name="bairro" 
                                   type="text" 
                                   placeholder="Nome do bairro" 
                                   value="{{ old('bairro') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required>
                        </div>
                        
                        <!-- Número da residência -->
                        <div>
                            <label for="numero_residencia" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-number-circle-one text-gray-400 mr-2"></i>
                                    Número *
                                </span>
                            </label>
                            <input id="numero_residencia" 
                                   name="numero_residencia" 
                                   type="text" 
                                   placeholder="123" 
                                   value="{{ old('numero_residencia') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required>
                        </div>
                        
                        <!-- Complemento -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="complemento" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-info text-gray-400 mr-2"></i>
                                    Complemento (opcional)
                                </span>
                            </label>
                            <input id="complemento" 
                                   name="complemento" 
                                   type="text" 
                                   placeholder="Apartamento 12, Bloco A, etc." 
                                   value="{{ old('complemento') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400">
                        </div>
                        
                        <!-- Senha -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="senha" class="block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <i class="ph ph-lock text-gray-400 mr-2"></i>
                                        Senha *
                                    </span>
                                </label>
                                <button type="button" 
                                        id="togglePassword" 
                                        class="text-sm text-gray-500 hover:text-orange-500 password-toggle">
                                    <span id="toggleText">Mostrar</span>
                                </button>
                            </div>
                            <input id="senha" 
                                   name="senha" 
                                   type="password" 
                                   placeholder="Crie uma senha forte" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="new-password">
                            <div class="mt-2">
                                <div id="passwordStrength" class="password-strength strength-weak"></div>
                                <p id="strengthText" class="text-xs text-gray-500 mt-1">Fraca</p>
                            </div>
                        </div>
                        
                        <!-- Confirmar Senha -->
                        <div>
                            <label for="senha_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <i class="ph ph-lock-key text-gray-400 mr-2"></i>
                                    Confirmar senha *
                                </span>
                            </label>
                            <input id="senha_confirmation" 
                                   name="senha_confirmation" 
                                   type="password" 
                                   placeholder="Digite a senha novamente" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="new-password">
                            <div id="passwordMatch" class="mt-2 text-xs text-red-500 hidden">
                                <i class="ph ph-warning-circle mr-1"></i>
                                As senhas não coincidem
                            </div>
                        </div>
                    </div>
                    
                    <!-- Termos e condições -->
                    <div class="mb-8">
                        <div class="flex items-start">
                            <input id="terms" 
                                   name="terms" 
                                   type="checkbox" 
                                   class="custom-checkbox mr-3 mt-1"
                                   required>
                            <label for="terms" class="text-sm text-gray-600 cursor-pointer select-none">
                                Eu concordo com os 
                                <a href="#" class="text-orange-500 hover:text-orange-600 font-medium">Termos de Uso</a>
                                e 
                                <a href="#" class="text-orange-500 hover:text-orange-600 font-medium">Política de Privacidade</a>
                                do Bistrô Terraço
                            </label>
                        </div>
                    </div>

                    <!-- Botão de cadastro -->
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full gradient-primary hover:gradient-primary-hover text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                        <i id="loadingIcon" class="ph ph-circle-notch hidden animate-spin mr-2"></i>
                        <span id="submitText">Criar minha conta</span>
                    </button>
                </form>
                
                <!-- Footer do card -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-center">
                    <p class="text-gray-600">
                        Já tem uma conta?
                        <a href="{{ route('login') }}" 
                           class="ml-1 font-bold text-orange-500 hover:text-orange-600 smooth-transition">
                            Faça login aqui
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Informações extras -->
            <div class="mt-6 text-center">
                <p class="text-gray-500 text-sm">
                    Seus dados são protegidos e nunca compartilhados com terceiros
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle para mostrar/esconder senha
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('senha');
        const toggleText = document.getElementById('toggleText');
        
        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleText.textContent = 'Ocultar';
                this.classList.add('text-orange-500');
            } else {
                passwordInput.type = 'password';
                toggleText.textContent = 'Mostrar';
                this.classList.remove('text-orange-500');
            }
        });

        // Validador de força da senha
        const passwordStrength = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('strengthText');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Critérios de força
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Atualizar visual
            passwordStrength.className = 'password-strength ';
            switch(strength) {
                case 0:
                case 1:
                    passwordStrength.classList.add('strength-weak');
                    strengthText.textContent = 'Fraca';
                    strengthText.className = 'text-xs text-red-500 mt-1';
                    break;
                case 2:
                    passwordStrength.classList.add('strength-medium');
                    strengthText.textContent = 'Média';
                    strengthText.className = 'text-xs text-yellow-500 mt-1';
                    break;
                case 3:
                    passwordStrength.classList.add('strength-good');
                    strengthText.textContent = 'Boa';
                    strengthText.className = 'text-xs text-green-500 mt-1';
                    break;
                case 4:
                    passwordStrength.classList.add('strength-strong');
                    strengthText.textContent = 'Forte';
                    strengthText.className = 'text-xs text-green-600 mt-1';
                    break;
            }
        });

        // Validador de confirmação de senha
        const confirmPassword = document.getElementById('senha_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');
        
        confirmPassword.addEventListener('input', function() {
            if (this.value && passwordInput.value !== this.value) {
                passwordMatch.classList.remove('hidden');
                this.classList.add('border-red-300');
            } else {
                passwordMatch.classList.add('hidden');
                this.classList.remove('border-red-300');
            }
        });

        // Buscar CEP via API
        const cepInput = document.getElementById('cep');
        const buscarCepBtn = document.getElementById('buscarCep');
        const ruaInput = document.getElementById('rua');
        const bairroInput = document.getElementById('bairro');
        
        function formatCEP(cep) {
            cep = cep.replace(/\D/g, '');
            if (cep.length > 5) {
                cep = cep.substring(0,5) + '-' + cep.substring(5,8);
            }
            return cep;
        }
        
        cepInput.addEventListener('input', function() {
            this.value = formatCEP(this.value);
        });
        
        buscarCepBtn.addEventListener('click', async function() {
            const cep = cepInput.value.replace(/\D/g, '');
            
            if (cep.length !== 8) {
                alert('Por favor, digite um CEP válido (8 dígitos)');
                return;
            }
            
            this.innerHTML = '<i class="ph ph-circle-notch animate-spin mr-2"></i>Buscando...';
            this.disabled = true;
            
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();
                
                if (data.erro) {
                    alert('CEP não encontrado. Por favor, verifique e tente novamente.');
                } else {
                    ruaInput.value = data.logradouro || '';
                    bairroInput.value = data.bairro || '';
                    
                    // Focar no campo de número se a rua foi preenchida
                    if (data.logradouro) {
                        document.getElementById('numero_residencia').focus();
                    }
                }
            } catch (error) {
                console.error('Erro ao buscar CEP:', error);
                alert('Erro ao buscar CEP. Por favor, preencha manualmente.');
            }
            
            this.innerHTML = 'Buscar';
            this.disabled = false;
        });

        // Formatação de telefone
        const telefoneInput = document.getElementById('telefone');
        
        telefoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 10) {
                // Formato: (11) 99999-9999
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 6) {
                // Formato: (11) 9999-9999
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else if (value.length > 0) {
                value = value.replace(/^(\d*)/, '($1');
            }
            
            this.value = value;
        });

        // Validação do formulário
        document.getElementById('cadastroForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingIcon = document.getElementById('loadingIcon');
            
            // Validar senhas
            if (passwordInput.value !== confirmPassword.value) {
                e.preventDefault();
                alert('As senhas não coincidem. Por favor, verifique.');
                confirmPassword.focus();
                return;
            }
            
            // Validar termos
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Você precisa aceitar os Termos de Uso e Política de Privacidade.');
                return;
            }
            
            // Validar senha forte
            if (passwordInput.value.length < 8) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 8 caracteres.');
                passwordInput.focus();
                return;
            }
            
            // Mostrar loading state
            submitText.textContent = 'Criando conta...';
            loadingIcon.classList.remove('hidden');
            submitBtn.disabled = true;
            
            // Timeout de fallback
            setTimeout(() => {
                submitText.textContent = 'Criar minha conta';
                loadingIcon.classList.add('hidden');
                submitBtn.disabled = false;
            }, 10000);
        });

        // Efeito de focus nos inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-orange-200');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-orange-200');
            });
        });

        // Preencher com dados de exemplo (apenas para desenvolvimento)
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            document.getElementById('email').value = 'cliente@exemplo.com';
            document.getElementById('nome').value = 'João Silva';
            document.getElementById('telefone').value = '(11) 99999-9999';
            document.getElementById('cep').value = '01310-100';
            document.getElementById('rua').value = 'Avenida Paulista';
            document.getElementById('bairro').value = 'Bela Vista';
            document.getElementById('numero_residencia').value = '1000';
            document.getElementById('senha').value = 'Senha123@';
            document.getElementById('senha_confirmation').value = 'Senha123@';
            console.log('Dados de exemplo preenchidos para desenvolvimento');
        }

        // Adicionar animação ao carregar
        document.addEventListener('DOMContentLoaded', function() {
            // Foco no primeiro campo
            setTimeout(() => {
                document.getElementById('email').focus();
            }, 300);
        });
    </script>
</body>
</html>