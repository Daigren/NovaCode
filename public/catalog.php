<?php
require_once __DIR__ . '/../includes/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="top-header">
    <div class="container header-container">
        <a href="index.php" class="logo">
            <span class="logo-icon">◲</span> NovaCode
        </a>
        <nav class="main-nav">
            <a href="index.php">главная</a>
            <a href="catalog.php" class="active">курсы</a>
            <a href="profile.php">настройки</a>
        </nav>
        <button class="btn-consult">консультация</button>
    </div>
</header>

<div class="search-bar">
    <div class="container search-container">
        <div class="search-input-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Поиск курсов (например, Python)...">
        </div>
        <div class="filter-wrapper">
            <select id="categoryFilter" class="filter-select">
                <option value="">Все направления</option>
                <option value="Python">Python</option>
                <option value="C++">C++</option>
                <option value="C#">C#</option>
                <option value="JavaScript">JavaScript</option>
                <option value="HTML">HTML & CSS</option>
                <option value="Java">Java</option>
            </select>
        </div>
    </div>
</div>

<main class="catalog-section">
    <div class="container">
        <h1 class="page-title">Доступные направления</h1>
        
        <div id="coursesContainer" class="courses-grid">
            </div>
    </div>
</main>

<footer class="app-footer">
    <div class="container footer-inner">
        <div class="footer-left">© 2026 NovaCode Team</div>
        <div class="footer-right">Панель управления</div>
    </div>
</footer>


<script>
// Получаем доступ к элементам DOM
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const container = document.getElementById('coursesContainer');

/**
 * Функция отправки запроса к API и отрисовки карточек
 */
async function fetchCourses() {
    const query = searchInput.value;
    const category = categoryFilter.value;

    try {
        // Формируем URL-запрос к обработчику в папке includes
        const url = `../includes/api/search.php?q=${encodeURIComponent(query)}&cat=${encodeURIComponent(category)}`;
        const response = await fetch(url);
        
        // Преобразуем полученный от бэкенда ответ в массив объектов
        const courses = await response.json();

        // Полностью очищаем контейнер перед выводом новых результатов
        container.innerHTML = '';

        // Если в БД не нашлось совпадений
        if (courses.length === 0) {
            container.innerHTML = '<p class="no-results">По вашему запросу ничего не найдено.</p>';
            return;
        }

        // Проходим циклом по каждому курсу из массива данных
        courses.forEach(course => {
            // Создаем HTML-элемент для карточки
            const card = document.createElement('div');
            card.className = 'course-card'; // Класс для стилизации в твоем CSS
            
            // Заполняем карточку шаблоном данных из таблицы БД
            card.innerHTML = `
                <div class="card-header">
                    <span class="course-badge">${course.category}</span>
                    <h3 class="course-title">${course.title}</h3>
                </div>
                <p class="course-desc">${course.description}</p>
                <div class="card-footer">
                    <span class="course-price">${course.price} ₽</span>
                    <a href="course.php?id=${course.id}" class="btn-more">Подробнее</a>
                </div>
            `;
            
            // Встраиваем готовую карточку в сетку на странице
            container.appendChild(card);
        });
    } catch (error) {
        console.error('Критическая ошибка поиска:', error);
        container.innerHTML = '<p class="error-message">Произошла ошибка при загрузке данных с сервера.</p>';
    }
}

// Вешаем слушатели событий на ввод текста и выбор фильтра
searchInput.addEventListener('input', fetchCourses);
categoryFilter.addEventListener('change', fetchCourses);

// Инициализируем вывод всех курсов сразу при открытии страницы
document.addEventListener('DOMContentLoaded', fetchCourses);
</script>

</body>
</html>