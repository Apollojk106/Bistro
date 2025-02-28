<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma De Pagamento</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>
<body class="bg-gray-100 text-white">

<x-hotbar-user />
    <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
    <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
      <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
    </a>
  </nav>


</body>
</html>