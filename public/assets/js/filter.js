document.addEventListener("DOMContentLoaded", function() {
    const filterBtn = document.getElementById('openFiltersBtn');
    const filterMenu = document.getElementById('filterMenu');

    if (filterBtn && filterMenu) {
        filterBtn.addEventListener('click', function() {
            filterMenu.classList.toggle('active'); 
        });
    }
});