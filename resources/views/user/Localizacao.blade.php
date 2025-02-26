<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localizacao</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Adicione o Tailwind CSS -->
</head>
<body class="bg-gray-100 text-white">

    <x-hotbar-user />
   

    <div class="bg-gray-200 p-4 rounded-lg shadow-lg w-80">
        <h2 class="text-xl font-bold text-center mb-4">Como nós encontrar</h2>

        <!-- Mapa -->
        <div id="map" class="w-full h-40 rounded-lg shadow-md"></div>

        <!-- Endereço -->
        <p class="text-sm text-center mt-2">
            Rua José Mari, 85 - Parque Assunção<br>
            Taboão da Serra - SP, 06754-140
        </p>

        <!-- Horário de funcionamento -->
        <div class="mt-3 text-center text-gray-700 text-sm">
            <p class="font-semibold">Horário de funcionamento</p>
            <p><strong>Dias:</strong> Seg a Sábado</p>
            <p><strong>Horário:</strong> 09:00 às 21:00</p>
        </div>

        <!-- Botão de localização -->
        <div class="mt-4 text-center">
            <button onclick="abrirGoogleMaps()" class="bg-orange-500 text-white font-semibold px-4 py-2 rounded-lg flex items-center mx-auto shadow-md hover:bg-orange-600">
                📍 Onde estamos
            </button>
        </div>

        <!-- Contato -->
        <div class="mt-5 text-center">
            <p class="text-lg font-semibold">Contate-nos</p>
            <p class="text-xl font-bold">(11) 556-1234</p>
            <div class="flex justify-center space-x-6 mt-2">
                <a href="#" class="text-2xl">📱</a>
                <a href="#" class="text-2xl">📸</a>
            </div>
        </div>
    </div>

    <script>
        // Coordenadas do endereço (baseado na localização aproximada)
        const latitude = -23.6011;
        const longitude = -46.7767;

        // Inicializa o mapa
        const map = L.map('map').setView([latitude, longitude], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Adiciona marcador no mapa
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup("Nosso Local")
            .openPopup();

        // Função para abrir Google Maps
        function abrirGoogleMaps() {
            window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
        }
    </script>
>

    
</body>
</html>