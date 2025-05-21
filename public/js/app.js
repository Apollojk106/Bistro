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

   
        // Função para alternar o estado do checkbox
        const checkbox = document.getElementById('checkbox');
        const checkboxIcon = document.getElementById('checkbox-icon');

        checkbox.addEventListener('click', () => {
            // Verifica se o checkbox está selecionado
            const isChecked = checkboxIcon.src.includes('checkbox.png');

            // Altera o ícone do checkbox
            if (isChecked) {
                checkboxIcon.src = "{{ asset('Icons/checkbox-empty.png') }}";
            } else {
                checkboxIcon.src = "{{ asset('Icons/check-green.png') }}";
            }

            // Mostra ou esconde o ícone
            checkboxIcon.classList.toggle('hidden');
        });
    
        document.getElementById('horarioInput').addEventListener('change', function () {
            const min = this.min;
            const max = this.max;
            const value = this.value;
        
            if (value < min || value > max) {
                alert(`Por favor, selecione um horário entre ${min} e ${max}.`);
                this.value = min; // Reseta para o valor mínimo
            }
        });
});
