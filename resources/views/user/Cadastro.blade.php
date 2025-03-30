<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>

<body class="bg-gray-100 text-white">

    <x-hotbar-user />
    <nav class="flex justify-center space-x-10 bg-[#2E2E2E] py-4"></nav>

    <div class="flex flex-col items-center justify-center h-full">

        <p class="text-black text-left mt-4">Cadastro</p>

        <form class="h-full max-h-md  rounded-lg " action="{{ route('User.Cadastro.Post') }}" method="post">
            @csrf <!-- Token CSRF para proteção contra ataques -->
            <div class="flex-grow p-4 max-h-screen m-4 rounded-lg bg-[#B7B7B7] m-4">
                <p class="text-black text-left">E-mail:</p>
                <input type="email" name="email" placeholder="Email..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Nome:</p>
                <input type="text" name="nome" placeholder="Nome..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Telefone:</p>
                <input type="text" name="telefone" placeholder="Telefone..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Cep:</p>
                <input type="text" name="cep" placeholder="Cep..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Rua:</p>
                <input type="text" name="rua" placeholder="Rua..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Bairro:</p>
                <input type="text" name="bairro" placeholder="Bairro..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Numero da residência:</p>
                <input type="text" name="numero_residencia" placeholder="Número da Residência..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Complemento (opcional):</p>
                <input type="text" name="complemento" placeholder="Complemento..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Senha:</p>
                <input type="password" name="senha" placeholder="Senha..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />

                <p class="text-black text-left">Confirmar Senha:</p>
                <input type="password" name="senha_confirmation" placeholder="Confirmar Senha..." class="text-black bg-transparent p-2 outline-none flex-1 border-0 border-b-2 border-black" />
            </div>

            <!-- Botão de Cadastro -->
            <button type="submit" class="bg-[#A74A04] rounded-lg p-2 w-full flex items-center justify-center hover:bg-[#8C3D03] transition duration-300">
                <span class="text-white font-bold">Cadastrar</span>
            </button>
        </form>

        <!-- Link de Cadastro -->
        <div class="mt-4 text-center mb-4">
            <a href="{{ route('User.Login') }}" class=" underline text-black font-bold hover:text-gray-700">Logar</a>
        </div>
        </form>
    </div>

</body>

</html>