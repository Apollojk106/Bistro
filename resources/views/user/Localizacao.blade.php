<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localização</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS e JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100 text-white">

    <!-- Menu Hamburguer (Hotbar) -->
    <x-hotbar-user class="z-50 fixed top-0 left-0 w-full" /> <!-- Menu fixo no topo com z-50 -->

    <nav class="flex justify-center relative bg-[#2E2E2E] py-6"></nav>

    <!-- Quadro centralizado -->
    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md mx-auto mt-16"> <!-- Adicione mt-16 para dar espaço ao menu -->
        <h2 class="text-2xl font-bold text-center mb-6 text-[#A74A04]">Como nos encontrar</h2>

        <!-- Mapa -->
        <div id="map" class="w-full h-48 rounded-lg shadow-md mb-6 relative z-10"></div> <!-- Adicione z-10 ao mapa -->

        <!-- Endereço -->
        <div class="text-center mb-6">
            <p class="text-lg font-semibold text-gray-700">R. José Mari, 88 - Parque Assunção</p>
            <p class="text-sm text-gray-600">Taboão da Serra - SP, 06754-140</p>
        </div>

        <!-- Horário de funcionamento -->
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p class="text-lg font-semibold text-center text-gray-700">Horário de funcionamento</p>
            <div class="text-center text-gray-600">
                <p><strong>Dias:</strong> Segunda a Sábado</p>
                <p><strong>Horário:</strong> 09:00 às 21:00</p>
            </div>
        </div>

        <!-- Botão de localização -->
        <div class="text-center mb-6">
            <button onclick="abrirGoogleMaps()" class="bg-[#A74A04] text-white font-semibold px-6 py-3 rounded-2xl flex items-center mx-auto shadow-md hover:bg-[#8B3D03] focus:ring-2 focus:ring-[#A74A04] focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
                <img src="{{ asset('Icons/local-point.png') }}" alt="Localização" class="w-6 h-6 mr-2" /> Onde estamos
            </button>
        </div>

        <!-- Contato -->
        <div class="text-center">
            <p class="text-lg font-semibold text-gray-700">Contate-nos</p>
            <p class="text-xl font-bold text-[#A74A04]">(11) 556-1234</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="text-2xl text-gray-600 hover:text-[#A74A04] transition-colors duration-300">
                    <img src="{{ asset('Icons/zap.png') }}" alt="WhatsApp" class="w-8 h-8" />
                </a>
                <a href="#" class="text-2xl text-gray-600 hover:text-[#A74A04] transition-colors duration-300">
                    <img src="{{ asset('Icons/instagram.png') }}" alt="Instagram" class="w-8 h-8" />
                </a>
            </div>
        </div>
    </div>

    <script>
        // Coordenadas atualizadas para R. José Mari, 88
        const latitude = -23.606466; // Latitude
        const longitude = -46.763430; // Longitude

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
</body>
</html>