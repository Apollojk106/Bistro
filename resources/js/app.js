import './bootstrap';


// Configuração do carrossel
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1.5,
    spaceBetween: 10,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    keyboard: {
        enabled: true,
    },
    mousewheel: true,
    grabCursor: true,
    touchEventsTarget: 'wrapper',
});

// MENU LATERAL
const menuToggle = document.getElementById("menuToggle");
const sideMenu = document.getElementById("sideMenu");
const closeMenu = document.getElementById("closeMenu");

// Abrir menu
menuToggle.addEventListener("click", () => {
    sideMenu.classList.add("open");
});

// Fechar menu
closeMenu.addEventListener("click", () => {
    sideMenu.classList.remove("open");
});
