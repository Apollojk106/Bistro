<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body class="bg-gray-100">
    <header class="header">
        <button class="menu-button" id="menuToggle">&#9776;</button>
        <h1 class="title">TERRAÇO</h1>
        <div class="icons">
            <button>📞</button>
            <button>📷</button>
        </div>
    </header>

    <!-- Menu Lateral -->
    <nav class="side-menu" id="sideMenu">
        <button class="close-menu" id="closeMenu">&times;</button>
        <ul>
            <li><a href="#">📜 Cardápio</a></li>
            <li><a href="#">🛒 Meus Pedidos</a></li>
            <li><a href="#">📍 Localização</a></li>
            <li><a href="#">⚙️ Configuração</a></li>
        </ul>
    </nav>

    <!-- Navegação Principal -->
    <nav class="nav-bar">
        <a href="#" class="nav-item">Pastel</a>
        <a href="#" class="nav-item active">Pratos do dia</a>
        <a href="#" class="nav-item">Tapioca</a>
    </nav>

    <main class="main-content">
        <h2 class="section-title">Pratos do dia</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide card">
                    <img src="comida.jpg" alt="Bife com batata" class="card-image">
                    <h3 class="card-title">Bife com batata</h3>
                    <p class="card-description">Arroz, feijão, batata frita crocante...</p>
                    <p class="card-price">R$ 25,00</p>
                </div>
                <div class="swiper-slide card">
                    <img src="comida.jpg" alt="Bife com batata" class="card-image">
                    <h3 class="card-title">Bife com batata</h3>
                    <p class="card-description">Arroz, feijão, batata frita crocante...</p>
                    <p class="card-price">R$ 25,00</p>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>