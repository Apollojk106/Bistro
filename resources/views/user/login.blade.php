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

<body class="bg-gray-100  min-h-screen">

    <x-hotbar-user />
    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="flex flex-col items-center justify-center min-h-screen">
    <form class="bg-[#B7B7B7] w-full max-w-md p-6 rounded-lg shadow-lg" action="{{ route('User.Perfil') }}" method="get">
        <!-- Div que ocupa o resto da tela -->
        <div class="flex-grow p-4 h-full bg-[#B7B7B7] m-4">
            <!-- Conteúdo da div do meio -->
            <p class="text-black text-center">Conteúdo aqui</p>
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