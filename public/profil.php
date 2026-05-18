<?php
require_once __DIR__ . '/../includes/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/filter.js" defer></script>
    <link rel="icon" type="image/svg+xml" href="assets/images/main.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <img src="./assets/images/iconHeader.svg" alt="icon">
        <a href="./index.php">
            Главная
        </a>
        <a href="./catalog.php">
            Курсы
        </a>
        <a href="./profil.php">
            Профиль
        </a>

        <button id="consultation" onclick="window.location.href='./consultation.php';">
            консультация
        </button>
    </header>

    <main>
        <div class="search-bar">
            <div class="container search-container">
                <form action="catalog.php" method="GET" style="width: 100%; display: flex; gap: 20px; align-items: center;">
                    <div class="search-input-wrapper" style="flex: 1;">
                        <span class="search-icon">
                            <img src="./assets/images/search.svg" alt="search">
                        </span>
                        <input type="text" name="q" id="searchInput" placeholder="Найти курс">
                    </div>
                    
                    <div class="filter-wrapper" style="position: relative;">
    
                        <button type="button" class="filter-btn" id="openFiltersBtn">≡ фильтры</button>
                        
                        <div id="filterMenu" class="filter-dropdown">
                            <div class="filter-header">Категории</div>
                            
                            <label class="filter-option">
                                <input type="radio" name="cat" value="" checked>
                                <span>Все направления</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="cat" value="Python">
                                <span>Python</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="cat" value="C++">
                                <span>C++</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="cat" value="C#">
                                <span>C#</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="cat" value="Java">
                                <span>Java</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        
    </main>

</body>
</html>