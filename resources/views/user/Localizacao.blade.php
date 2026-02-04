<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localização - Bistrô Terraço</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Leaflet CSS e JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        /* Estilos personalizados */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        .gradient-orange-hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        }
        
        .shadow-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .shadow-card-hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        /* Animação de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Custom marker para o mapa */
        .custom-marker {
            width: 40px;
            height: 40px;
            background: #f97316;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .custom-marker::after {
            content: '';
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
        }
        
        /* Estilo do mapa */
        #map {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilo dos cards de informação */
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilo dos horários */
        .hour-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .hour-item:last-child {
            border-bottom: none;
        }
        
        /* Responsividade */
        @media (max-width: 640px) {
            .info-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <x-hotbar-user />

    <!-- Container principal -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-10 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <i class="ph ph-map-pin text-2xl text-orange-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Nossa Localização</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Venha nos visitar no Bistrô Terraço! Estamos localizados em Taboão da Serra, 
                prontos para receber você com o melhor da nossa gastronomia.
            </p>
        </div>

        <!-- Grid de conteúdo -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna 1: Mapa -->
            <div class="lg:col-span-2 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="bg-white rounded-2xl shadow-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="ph ph-map-trifold text-orange-500 mr-2"></i>
                            Encontre o caminho
                        </h2>
                        <button onclick="abrirGoogleMaps()" 
                                class="flex items-center text-sm text-orange-500 hover:text-orange-600 font-medium smooth-transition">
                            <i class="ph ph-arrow-square-out mr-2"></i>
                            Abrir no Google Maps
                        </button>
                    </div>
                    
                    <!-- Mapa Leaflet -->
                    <div id="map" class="w-full h-96 rounded-xl overflow-hidden"></div>
                    
                    <!-- Coordenadas -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="ph ph-crosshair-simple mr-2"></i>
                            <span>Latitude: -23.606466</span>
                        </div>
                        <div class="flex items-center">
                            <i class="ph ph-crosshair-simple mr-2"></i>
                            <span>Longitude: -46.763430</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna 2: Informações -->
            <div class="animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="space-y-6">
                    <!-- Endereço -->
                    <div class="info-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ph ph-buildings text-orange-500"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Endereço</h3>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-700 flex items-center">
                                <i class="ph ph-road-horizon text-gray-400 mr-2 w-5"></i>
                                R. José Mari, 88 - Parque Assunção
                            </p>
                            <p class="text-gray-700 flex items-center">
                                <i class="ph ph-map-pin text-gray-400 mr-2 w-5"></i>
                                Taboão da Serra - SP
                            </p>
                            <p class="text-gray-700 flex items-center">
                                <i class="ph ph-postal-code text-gray-400 mr-2 w-5"></i>
                                CEP: 06754-140
                            </p>
                        </div>
                    </div>

                    <!-- Horário de funcionamento -->
                    <div class="info-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ph ph-clock text-orange-500"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Horário de funcionamento</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="hour-item">
                                <span class="text-gray-700 font-medium">Segunda a Sexta</span>
                                <span class="text-orange-600 font-bold">09:00 - 21:00</span>
                            </div>
                            <div class="hour-item">
                                <span class="text-gray-700 font-medium">Sábado</span>
                                <span class="text-orange-600 font-bold">09:00 - 21:00</span>
                            </div>
                            <div class="hour-item">
                                <span class="text-gray-700 font-medium">Domingo</span>
                                <span class="text-orange-600 font-bold text-gray-400">Fechado</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500">
                                <i class="ph ph-info text-gray-400 mr-2"></i>
                                Último pedido às 20:30
                            </p>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="info-card">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ph ph-phone text-orange-500"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Contato</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="ph ph-phone text-gray-400 mr-3 w-5"></i>
                                <div>
                                    <p class="text-gray-700 font-medium">Telefone</p>
                                    <a href="tel:+55115561234" 
                                       class="text-lg font-bold text-orange-500 hover:text-orange-600 smooth-transition">
                                        (11) 556-1234
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="ph ph-envelope-simple text-gray-400 mr-3 w-5"></i>
                                <div>
                                    <p class="text-gray-700 font-medium">E-mail</p>
                                    <a href="mailto:contato@bistroteterraco.com" 
                                       class="text-orange-500 hover:text-orange-600 smooth-transition">
                                        contato@bistroteterraco.com
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de botões de ação -->
        <div class="mt-12 animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Botão de rotas -->
                <button onclick="abrirGoogleMaps()" 
                        class="gradient-orange hover:gradient-orange-hover text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                    <i class="ph ph-navigation-arrow text-xl mr-3"></i>
                    <div class="text-left">
                        <p class="text-lg">Traçar rota</p>
                        <p class="text-sm opacity-90">Google Maps</p>
                    </div>
                </button>

                <!-- Botão de ligar -->
                <a href="tel:+55115561234" 
                   class="bg-white border-2 border-orange-500 text-orange-500 hover:bg-orange-50 font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                    <i class="ph ph-phone text-xl mr-3"></i>
                    <div class="text-left">
                        <p class="text-lg">Ligar agora</p>
                        <p class="text-sm opacity-90">(11) 556-1234</p>
                    </div>
                </a>

                <!-- Botão de compartilhar -->
                <button onclick="compartilharLocalizacao()" 
                        class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg smooth-transition transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center">
                    <i class="ph ph-share-network text-xl mr-3"></i>
                    <div class="text-left">
                        <p class="text-lg">Compartilhar</p>
                        <p class="text-sm opacity-90">Localização</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Seção de redes sociais -->
        <div class="mt-12 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="bg-white rounded-2xl shadow-card p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Siga-nos nas redes sociais</h2>
                    <p class="text-gray-600">Fique por dentro das novidades e promoções</p>
                </div>
                <div class="flex justify-center space-x-8">
                    <a href="https://wa.me/55115561234" 
                       target="_blank"
                       class="flex flex-col items-center group">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 smooth-transition mb-3">
                            <i class="ph ph-whatsapp-logo text-3xl text-green-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">WhatsApp</span>
                        <span class="text-xs text-gray-500">(11) 556-1234</span>
                    </a>
                    <a href="https://instagram.com/bistroteterraco" 
                       target="_blank"
                       class="flex flex-col items-center group">
                        <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-200 smooth-transition mb-3">
                            <i class="ph ph-instagram-logo text-3xl text-pink-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Instagram</span>
                        <span class="text-xs text-gray-500">@bistroteterraco</span>
                    </a>
                   
                </div>
            </div>
        </div>

     

    <script>
        // Coordenadas para R. José Mari, 88 - Taboão da Serra
        const latitude = -23.606466;
        const longitude = -46.763430;

        // Inicializa o mapa
        const map = L.map('map').setView([latitude, longitude], 16);
        
        // Tile Layer personalizado
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Criar ícone personalizado
        const customIcon = L.divIcon({
            className: 'custom-marker',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        // Adicionar marcador com popup
        const marker = L.marker([latitude, longitude], { icon: customIcon }).addTo(map);
        
        marker.bindPopup(`
            <div style="font-family: system-ui, -apple-system, sans-serif;">
                <div class="font-bold text-lg text-orange-600 mb-1">Bistrô Terraço</div>
                <div class="text-gray-700 text-sm">
                    <p><strong>Endereço:</strong> R. José Mari, 88</p>
                    <p><strong>Bairro:</strong> Parque Assunção</p>
                    <p><strong>Telefone:</strong> (11) 556-1234</p>
                </div>
                <button onclick="abrirGoogleMaps()" 
                        style="margin-top: 8px; padding: 6px 12px; background: #f97316; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; width: 100%;">
                    Ver rotas →
                </button>
            </div>
        `);

        // Abrir popup ao carregar
        setTimeout(() => {
            marker.openPopup();
        }, 1000);

        // Função para abrir Google Maps
        function abrirGoogleMaps() {
            const url = `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}&travelmode=driving`;
            window.open(url, '_blank');
        }

        // Função para compartilhar localização
        function compartilharLocalizacao() {
            if (navigator.share) {
                navigator.share({
                    title: 'Bistrô Terraço',
                    text: 'Venha nos visitar no Bistrô Terraço!',
                    url: `https://www.google.com/maps?q=${latitude},${longitude}`
                })
                .then(() => console.log('Localização compartilhada com sucesso!'))
                .catch((error) => console.log('Erro ao compartilhar:', error));
            } else {
                // Fallback para copiar link
                const link = `https://www.google.com/maps?q=${latitude},${longitude}`;
                navigator.clipboard.writeText(link)
                    .then(() => alert('Link da localização copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar:', err));
            }
        }

        // Adicionar controles de zoom ao mapa
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Adicionar escala
        L.control.scale({
            imperial: false,
            metric: true
        }).addTo(map);

        // Função para buscar rota atual do usuário
        function buscarMinhaLocalizacao() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        // Adicionar marcador da localização do usuário
                        L.marker([userLat, userLng], {
                            icon: L.divIcon({
                                className: 'user-location-marker',
                                html: '<div style="background: #3b82f6; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12]
                            })
                        }).addTo(map)
                        .bindPopup('Sua localização atual')
                        .openPopup();
                        
                        // Ajustar o mapa para mostrar ambos os marcadores
                        const bounds = L.latLngBounds(
                            [latitude, longitude],
                            [userLat, userLng]
                        );
                        map.fitBounds(bounds, { padding: [50, 50] });
                        
                        // Mostrar mensagem
                        alert('Sua localização foi adicionada ao mapa!');
                    },
                    (error) => {
                        console.error('Erro ao obter localização:', error);
                        alert('Não foi possível obter sua localização. Verifique as permissões do navegador.');
                    }
                );
            } else {
                alert('Geolocalização não é suportada pelo seu navegador.');
            }
        }

        // Adicionar evento para animações
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona delay progressivo nas animações
            document.querySelectorAll('.animate-fade-in-up').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>