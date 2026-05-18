document.addEventListener('DOMContentLoaded', () => {
    const filterBtn = document.getElementById('openFiltersBtn');
    const filterMenu = document.getElementById('filterMenu');

    // 1. Открытие/закрытие меню по клику на кнопку
    filterBtn.addEventListener('click', (event) => {
        // Переключаем класс 'show' (есть класс - показываем, нет - скрываем)
        filterMenu.classList.toggle('show');
        
        // Останавливаем "всплытие" клика, чтобы он не дошел до document (ниже)
        event.stopPropagation(); 
    });

    // 2. Закрытие меню при клике в любое пустое место на сайте
    document.addEventListener('click', (event) => {
        // Если клик был НЕ по меню и НЕ по кнопке открытия
        if (!filterMenu.contains(event.target) && event.target !== filterBtn) {
            filterMenu.classList.remove('show');
        }
    });
});