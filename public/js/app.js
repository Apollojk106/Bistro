document.addEventListener("DOMContentLoaded", function () {
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

    if (menuToggle && sideMenu && closeMenu) {
        menuToggle.addEventListener("click", () => {
            sideMenu.classList.add("open");
        });

        closeMenu.addEventListener("click", () => {
            sideMenu.classList.remove("open");
        });
    }
});
