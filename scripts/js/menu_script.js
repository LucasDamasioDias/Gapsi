document.addEventListener('DOMContentLoaded', () => {
    // Seleciona o botão e o menu
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');

    // Adiciona o evento de clique
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('menu-mobile');
    });
});
