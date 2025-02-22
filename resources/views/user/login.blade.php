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

<body class="bg-gray-100 bg-[#B7B7B7] ">

    <x-hotbar-user />
    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="flex flex-col items-center justify-center h-full">

        <p class="text-black text-left">Seja bem vindo</p>

        <form class="h-full max-h-md p-6 rounded-lg " action="{{ route('User.Perfil') }}" method="get">
            <!-- Div que ocupa o resto da tela -->
            <div class="flex-grow p-4 max-h-screen m-4 rounded-lg bg-[#B7B7B7] m-4">
                <!-- Conteúdo da div do meio -->
                <p class="text-black text-left">Login:</p>
                <input type="text" placeholder="Email..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Senha:</p>
                <input type="text" placeholder="Senha..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

            </div>

            <!-- Botão de Logar -->
            <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition duration-300">
                <span class="text-white font-bold">Logar</span>
            </button>

            <!-- Link de Cadastro -->
            <div class="mt-4 text-center">
                <a href="{{ route('User.Cadastro') }}" class="underline text-black font-bold hover:text-gray-700">Cadastro</a>
            </div>
        </form>
    </div>

</body>

</html>