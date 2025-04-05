<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <x-hotbar-user />
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>

    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#A74A04]">Opção do Pedido</h2>

        <form class="space-y-6" method="POST" action="{{ route('User.OpcaoPedido.Post') }}" onsubmit="return validateForm()" id="pedidoForm">
            @csrf
            <!-- Nome -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Nome*</label>
                <input type="text" name="nome" id="nome" placeholder="Nome..." class="w-full bg-gray-200 p-3 rounded-md text-gray-700" required>
                <span id="nomeError" class="text-red-500 text-sm hidden">Nome é obrigatório</span>
            </div>

            <!-- Telefone -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Telefone*</label>
                <input type="tel" name="telefone" id="telefone" placeholder="11...." class="w-full bg-gray-200 p-3 rounded-md text-gray-700" required>
                <span id="telefoneError" class="text-red-500 text-sm hidden">Telefone é obrigatório</span>
            </div>

            <!-- E-mail -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" class="w-full bg-gray-200 p-3 rounded-md text-gray-700">
                <span id="emailError" class="text-red-500 text-sm hidden">E-mail inválido</span>
            </div>

            @if(session('opcoes.categoria') === 'Entrega')
            <!-- CEP -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">CEP*</label>
                <input type="text" name="cep" id="cep" placeholder="00000-000" class="w-full bg-gray-200 p-3 rounded-md text-gray-700" 
                       required
                       oninput="formatCEP(this)"
                       onblur="validateCEPOnBlur(this.value)">
                <span id="cepError" class="text-red-500 text-sm hidden">CEP inválido. Formato correto: 00000-000</span>
                <span id="cepNotFoundError" class="text-red-500 text-sm hidden">CEP não encontrado</span>
            </div>

            <!-- Rua -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Rua*</label>
                <input type="text" name="rua" id="rua" placeholder="Rua Exemplo" class="w-full bg-gray-200 p-3 rounded-md text-gray-700" required>
                <span id="ruaError" class="text-red-500 text-sm hidden">Rua é obrigatória</span>
            </div>

            <!-- Bairro -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Bairro*</label>
                <input type="text" name="bairro" id="bairro" placeholder="Bairro Exemplo" class="w-full bg-gray-200 p-3 rounded-md text-gray-700" required>
                <span id="bairroError" class="text-red-500 text-sm hidden">Bairro é obrigatório</span>
            </div>

            <!-- Número da casa -->
            <div class="flex items-center justify-between">
                <label class="text-sm font-semibold text-gray-700">Número da casa*</label>
                <input type="text" name="numero_residencia" id="numero" placeholder="123" class="bg-gray-200 p-2 rounded-md w-14 text-center text-gray-700" required>
                <span id="numeroError" class="text-red-500 text-sm hidden">Número é obrigatório</span>
            </div>

            <!-- Complemento -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Complemento</label>
                <input type="text" name="complemento" id="complemento" placeholder="Apartamento 101" class="w-full bg-gray-200 p-3 rounded-md text-gray-700">
            </div>

            @endif

            <!-- Botão de continuar -->
            <div class="fixed-bottom">
                <div class="w-full bg-gray-300 rounded-2xl flex items-center justify-between px-4 py-3 transition-all duration-300 ease-in-out hover:shadow-lg">
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-lg">R$ {{ $Pedido['valor'] ?? '0,00' }}</span>
                        <span class="text-sm text-gray-600 ml-2">{{ $Pedido['quantidade'] ?? '0' }} itens</span>
                    </div>
                    <button type="submit" class="bg-orange-800 text-white text-base font-medium px-6 py-3 rounded-2xl hover:bg-orange-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Continuar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Variável global para controlar se o CEP é válido
        let cepValido = false;

        // Formata o CEP enquanto o usuário digita
        function formatCEP(input) {
            let value = input.value.replace(/\D/g, '');
            
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }
            
            input.value = value;
        }

        // Valida o CEP quando o campo perde o foco
        function validateCEPOnBlur(cepValue) {
            const cepError = document.getElementById('cepError');
            const cepNotFoundError = document.getElementById('cepNotFoundError');
            
            // Resetar estados
            cepError.classList.add('hidden');
            cepNotFoundError.classList.add('hidden');
            cepValido = false;
            
            // Verificar se o campo está vazio (se for obrigatório)
            if (cepValue.trim() === '') {
                cepError.textContent = 'CEP é obrigatório';
                cepError.classList.remove('hidden');
                return false;
            }
            
            // Validar formato
            if (!validateCEPFormat(cepValue)) {
                cepError.textContent = 'CEP inválido. Formato correto: 00000-000';
                cepError.classList.remove('hidden');
                return false;
            }
            
            // Se chegou aqui, o formato é válido
            cepValido = true;
            return true;
        }

        // Valida apenas o formato do CEP
        function validateCEPFormat(cep) {
            const re = /^\d{5}-?\d{3}$/;
            return re.test(String(cep));
        }

        // Função principal de validação do formulário
        function validateForm() {
            let isValid = true;
            const nome = document.getElementById('nome').value;
            const telefone = document.getElementById('telefone').value;
            const email = document.getElementById('email').value;
            
            // Validar campos básicos
            if (nome.trim() === '') {
                document.getElementById('nomeError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('nomeError').classList.add('hidden');
            }

            if (telefone.trim() === '') {
                document.getElementById('telefoneError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('telefoneError').classList.add('hidden');
            }

            if (email.trim() !== '' && !validateEmail(email)) {
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('emailError').classList.add('hidden');
            }

            // Se for entrega, validar campos de endereço
            @if(session('opcoes.categoria') === 'Entrega')
                const cep = document.getElementById('cep').value;
                const rua = document.getElementById('rua').value;
                const bairro = document.getElementById('bairro').value;
                const numero = document.getElementById('numero').value;

                // Validar CEP
                if (!validateCEPOnBlur(cep)) {
                    isValid = false;
                }

                if (rua.trim() === '') {
                    document.getElementById('ruaError').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('ruaError').classList.add('hidden');
                }

                if (bairro.trim() === '') {
                    document.getElementById('bairroError').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('bairroError').classList.add('hidden');
                }

                if (numero.trim() === '') {
                    document.getElementById('numeroError').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('numeroError').classList.add('hidden');
                }
            @endif

            // Se não for válido, rolar até o primeiro erro
            if (!isValid) {
                const firstError = document.querySelector('[class*="Error"]:not(.hidden)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            return isValid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }
    </script>

</body>
</html>