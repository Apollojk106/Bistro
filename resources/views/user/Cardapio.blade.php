<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body class="bg-gray-100">

<x-hotbar-user />

   
    

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
    <script src="js/app.js"></script>

</body>
</html>