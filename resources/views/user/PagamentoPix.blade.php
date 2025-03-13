<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-white">

    <!-- Hotbar -->
    <x-hotbar-user />

    <!-- Navbar com botão de voltar -->
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
        <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
            <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
        </a>
    </nav>

    <!-- Conteúdo principal -->
    <div class="min-h-screen flex flex-col items-center p-4 pt-8">
        <!-- Título "Pagamento" -->
        <h1 class="text-3xl font-bold text-[#2E2E2E] mb-8 transition-all duration-300 ease-in-out transform hover:scale-105">Pagamento</h1>

        <!-- Caixa do QR Code -->
        <div class="w-full max-w-md bg-[#B7B7B7] rounded-2xl shadow-lg p-6 text-center transition-all duration-300 ease-in-out transform hover:scale-105">
            <!-- Valor -->
            <p class="text-xl font-semibold text-[#2E2E2E] mb-6">Total: <span class="text-[#A74A04]">R$ 64,40</span></p>

            <!-- QR Code -->
            <div class="mb-6">
                <img src="{{ asset('Icons/qrcode.png') }}" alt="QR Code" class="mx-auto w-48 h-48 transition-transform transform hover:scale-110">
            </div>

            <!-- Botão para copiar código -->
            <button id="copyButton" class="w-full bg-[#A74A04] text-white font-semibold py-3 rounded-lg hover:bg-[#8B3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Copiar Código
            </button>

            <!-- Código -->
            <p id="code" class="text-lg text-gray-700 mt-6 transition-all duration-300 ease-in-out hover:text-gray-900">a56c-4928-93be-9b7bf14beeab</p>
        </div>

        <!-- Mensagem de tempo (fora da caixa cinza) -->
        <p class="text-sm text-gray-600 mt-6 transition-all duration-300 ease-in-out hover:text-gray-800">O pagamento deve ser efetuado em até 10 minutos.</p>
    </div>

    <script>
        // Função para copiar o código
        document.getElementById("copyButton").addEventListener("click", function() {
            const codeText = document.getElementById("code").innerText;
            navigator.clipboard.writeText(codeText).then(() => {
                alert("Código copiado!");
            });
        });
    </script>

</body>
</html>