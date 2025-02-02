document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');
    const overlay = document.querySelector('.menu-overlay');

    menuToggle.addEventListener('click', () => {
        const isMenuOpen = menu.classList.toggle('menu-mobile'); // Alterna o menu

        if (isMenuOpen) {
            overlay.classList.add('menu-overlay'); // Adiciona classe para exibir
            overlay.style.display = 'block';
        } else {
            overlay.classList.remove('menu-overlay'); // Remove a classe
            overlay.style.display = 'none';
        }
    });
});

