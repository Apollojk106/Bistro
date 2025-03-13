<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>

<body class="bg-gray-100 bg-[#B7B7B7]">

    <x-hotbar-user />
    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <!-- Mensagem de boas-vindas -->
        <p class="text-black text-left text-xl font-semibold mb-4 transition-all duration-300 ease-in-out transform hover:scale-105">Seja bem-vindo</p>

        <!-- Formulário de Login -->
        <form class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105" action="{{ route('User.Perfil') }}" method="get">
            <!-- Campos de entrada -->
            <div class="space-y-6">
                <!-- Campo de Email -->
                <div>
                    <p class="text-black text-left text-lg font-medium mb-2">Login:</p>
                    <input type="text" placeholder="Email..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" />
                </div>

                <!-- Campo de Senha -->
                <div>
                    <p class="text-black text-left text-lg font-medium mb-2">Senha:</p>
                    <input type="password" placeholder="Senha..." class="w-full text-black bg-transparent p-2 outline-none border-0 border-b-2 border-black focus:border-[#A74A04] transition-all duration-300 ease-in-out" />
                </div>
            </div>

            <!-- Botão de Logar -->
            <button type="submit" class="w-full bg-[#A74A04] text-white font-bold py-3 rounded-lg mt-8 hover:bg-[#8C3D03] transition-all duration-300 ease-in-out transform hover:scale-105">
                Logar
            </button>

            <!-- Link de Cadastro -->
            <div class="mt-6 text-center">
                <a href="{{ route('User.Cadastro') }}" class="underline text-black font-bold hover:text-gray-700 transition-all duration-300 ease-in-out">Cadastro</a>
            </div>
        </form>
    </div>

</body>

</html>