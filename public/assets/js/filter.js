document.addEventListener("DOMContentLoaded", function() {
    const filterBtn = document.getElementById('openFiltersBtn');
    const filterMenu = document.getElementById('filterMenu');

    // Проверяем, существуют ли кнопка и меню на ЭТОЙ конкретной странице
    if (filterBtn && filterMenu) {
        filterBtn.addEventListener('click', function() {
            // Твой старый код открытия/закрытия фильтров
            filterMenu.classList.toggle('active'); 
        });
    }
});