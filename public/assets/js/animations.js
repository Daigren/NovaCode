document.addEventListener("DOMContentLoaded", function() {
    // Настраиваем наблюдателя
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            // Если элемент появился на экране хотя бы на 10%
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Перестаем следить за ним, чтобы анимация проигралась только один раз
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // 10% видимости
    });

    // Находим все элементы с классом fade-element и отдаем их наблюдателю
    const hiddenElements = document.querySelectorAll('.fade-element');
    hiddenElements.forEach((el) => observer.observe(el));
});