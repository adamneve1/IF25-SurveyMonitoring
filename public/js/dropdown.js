document.addEventListener('DOMContentLoaded', () => {
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');

    dropdownTriggers.forEach((trigger) => {
        trigger.addEventListener('click', function () {
            // Tutup semua dropdown lain dan reset panah
            const openMenus = document.querySelectorAll('.dropdown-menu.open');
            const rotatedArrows = document.querySelectorAll('.dropdown-trigger img.rotate');
            
            openMenus.forEach((menu) => {
                menu.classList.remove('open');
            });

            rotatedArrows.forEach((arrow) => {
                arrow.classList.remove('rotate');
            });

            // Buka dropdown yang di-klik dan putar panah
            const dropdownMenu = this.nextElementSibling;
            const arrowIcon = this.querySelector('img');

            if (!dropdownMenu.classList.contains('open')) {
                dropdownMenu.classList.add('open');
                arrowIcon.classList.add('rotate');
            } else {
                dropdownMenu.classList.remove('open');
                arrowIcon.classList.remove('rotate');
            }
        });
    });
});
