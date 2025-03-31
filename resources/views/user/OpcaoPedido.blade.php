<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>

<body class="bg-gray-100">


    <x-hotbar-user />
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>



    <!-- Quadro centralizado -->
    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md mx-auto mt-10"> <!-- Ajustado mt-16 para mt-10 -->
        <h2 class="text-2xl font-bold text-center mb-6 text-[#A74A04]">Opção do Pedido</h2>

        <form class="space-y-6" method="POST" action="{{ route('User.OpcaoPedid.Post') }}" onsubmit="return validateForm()">
            @csrf <!-- Token CSRF para segurança -->
            <!-- Nome -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">Nome*</label>
                <input type="text" name="nome" id="nome" placeholder="Apollo" class="w-full bg-gray-200 p-3 rounded-md text-gray-700" required>
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

            <!-- CEP -->
            <div>
                <label class="block text-left text-sm font-semibold text-gray-700">CEP</label>
                <input type="text" name="cep" id="cep" placeholder="00000-000" class="w-full bg-gray-200 p-3 rounded-md text-gray-700">
                <span id="cepError" class="text-red-500 text-sm hidden">CEP inválido</span>
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

            <!-- Taxa de entrega 
            <div class="flex justify-between text-sm font-semibold mt-6 text-gray-700">
                <span>Taxa da entrega</span>
                <span>R$ 10,25</span>
            </div> -->
        </form>
    </div>



    <script>
        function validateForm() {
            let nome = document.getElementById('nome').value;
            let telefone = document.getElementById('telefone').value;
            let email = document.getElementById('email').value;
            let cep = document.getElementById('cep').value;
            let numero = document.getElementById('numero').value;
            let rua = document.getElementById('rua').value;
            let bairro = document.getElementById('bairro').value;

            let nomeError = document.getElementById('nomeError');
            let telefoneError = document.getElementById('telefoneError');
            let emailError = document.getElementById('emailError');
            let cepError = document.getElementById('cepError');
            let numeroError = document.getElementById('numeroError');
            let ruaError = document.getElementById('ruaError');
            let bairroError = document.getElementById('bairroError');

            let isValid = true;

            if (nome.trim() === '') {
                nomeError.classList.remove('hidden');
                isValid = false;
            } else {
                nomeError.classList.add('hidden');
            }

            if (telefone.trim() === '') {
                telefoneError.classList.remove('hidden');
                isValid = false;
            } else {
                telefoneError.classList.add('hidden');
            }

            if (email.trim() !== '' && !validateEmail(email)) {
                emailError.classList.remove('hidden');
                isValid = false;
            } else {
                emailError.classList.add('hidden');
            }

            if (cep.trim() !== '' && !validateCEP(cep)) {
                cepError.classList.remove('hidden');
                isValid = false;
            } else {
                cepError.classList.add('hidden');
            }

            if (numero.trim() === '') {
                numeroError.classList.remove('hidden');
                isValid = false;
            } else {
                numeroError.classList.add('hidden');
            }

            if (rua.trim() === '') {
                ruaError.classList.remove('hidden');
                isValid = false;
            } else {
                ruaError.classList.add('hidden');
            }

            if (bairro.trim() === '') {
                bairroError.classList.remove('hidden');
                isValid = false;
            } else {
                bairroError.classList.add('hidden');
            }

            return isValid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function validateCEP(cep) {
            const re = /^\d{5}-\d{3}$/;
            return re.test(String(cep));
        }
    </script>

</body>

</html>