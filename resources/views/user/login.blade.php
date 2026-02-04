<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bistrô Terraço</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
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
        
        /* Efeito de float */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
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
    </style>
</head>

<body class="gradient-bg min-h-screen">
    <x-hotbar-user />
    
    <!-- Container principal -->
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4 animate-float">
                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Bem-vindo de volta!</h1>
            <p class="text-gray-600">Faça login para continuar suas compras</p>
        </div>

        <!-- Card do formulário -->
        <div class="w-full max-w-md animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header do card -->
                <div class="gradient-primary text-white py-6 px-8 text-center">
                    <h2 class="text-2xl font-bold">Acesse sua conta</h2>
                    <p class="text-orange-100 mt-1">Entre com seus dados</p>
                </div>
                
                <!-- Formulário -->
                <form class="p-8" action="{{ route('User.Login.Post') }}" method="POST" id="loginForm">
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
                    
                    <!-- Campo de email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                E-mail
                            </span>
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   placeholder="seu@email.com" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="email"
                                   autofocus>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Campo de senha -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label for="senha" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Senha
                                </span>
                            </label>
                            <!-- Botão para mostrar/esconder senha -->
                            <button type="button" 
                                    id="togglePassword" 
                                    class="text-sm text-gray-500 hover:text-orange-500 password-toggle">
                                <span id="toggleText">Mostrar</span>
                            </button>
                        </div>
                        <div class="relative">
                            <input id="senha" 
                                   name="senha" 
                                   type="password" 
                                   placeholder="Digite sua senha" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg input-focus focus:outline-none focus:bg-white text-gray-900 placeholder-gray-400"
                                   required
                                   autocomplete="current-password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Lembrar-me e Esqueci a senha -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="custom-checkbox mr-2"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">
                                Lembrar-me
                            </label>
                        </div>
                        <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium smooth-transition">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <!-- Botão de login -->
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full gradient-primary hover:gradient-primary-hover text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                        <svg id="loadingIcon" class="hidden w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="submitText">Entrar na minha conta</span>
                    </button>
                </form>
                
                <!-- Footer do card -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-center">
                    <p class="text-gray-600">
                        Não tem uma conta?
                        <a href="{{ route('User.Cadastro') }}" 
                           class="ml-1 font-bold text-orange-500 hover:text-orange-600 smooth-transition">
                            Cadastre-se aqui
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Informações extras -->
            <div class="mt-6 text-center">
                <p class="text-gray-500 text-sm">
                    Ao fazer login, você concorda com nossos
                    <a href="#" class="text-orange-500 hover:text-orange-600 smooth-transition">Termos de Uso</a>
                    e
                    <a href="#" class="text-orange-500 hover:text-orange-600 smooth-transition">Política de Privacidade</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle para mostrar/esconder senha
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('senha');
            const toggleText = document.getElementById('toggleText');
            
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

        // Validação do formulário
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const senha = document.getElementById('senha').value;
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingIcon = document.getElementById('loadingIcon');
            
            // Validação básica
            if (!email || !senha) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            
            // Validação de email simples
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Por favor, insira um endereço de e-mail válido.');
                return;
            }
            
            // Mostrar loading state
            submitText.textContent = 'Processando...';
            loadingIcon.classList.remove('hidden');
            submitBtn.disabled = true;
            
            // Timeout de fallback (caso demore muito)
            setTimeout(() => {
                submitText.textContent = 'Entrar na minha conta';
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
            document.getElementById('senha').value = 'senha123';
            console.log('Dados de exemplo preenchidos para desenvolvimento');
        }

        // Adicionar animação ao carregar
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona delay progressivo aos elementos
            const animatedElements = document.querySelectorAll('.animate-fade-in-up');
            animatedElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Foco no primeiro campo
            setTimeout(() => {
                document.getElementById('email').focus();
            }, 300);
        });
    </script>
</body>
</html>