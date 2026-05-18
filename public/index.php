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

        <section id="mainContent">
            <h1>
                NovaCode: Your Quantum Leap into IT
            </h1>

            <div id="buttonsWrapper">
                <button class="view_courses">
                    посмотреть курсы
                </button>
                
                <button class="consultation_2">
                    консультация
                </button>
            </div>

            <h3 id="description">
                Профессиональная экосистема для изучения современных технологий. Мы превращаем сложные концепции в понятный код, а новичков — в востребованных инженеров.
            <h3>
        </section>

        <section id="aiAdvisorSection">
            <h2 id="ai-advisor">AI-Mentor NovaCode</h2>

            <h3>
                Проконсультируйся с нашим ИИ-ментором, чтобы подобрать идеальный язык программирования для старта в IT. Просто расскажи о своих интересах, и мы поможем тебе сделать первый шаг к карьере мечты!
            </h3>

            <section id="videoSection">
                <video autoplay muted loop playsinline width="100%">
                    <source src="assets/videos/main-intro.mp4" type="video/mp4">
                </video>
                <dev>
                    <p>
                        Наш ИИ-ментор — это твой персональный гид в мире программирования. Он поможет тебе выбрать язык, который идеально подходит для твоих целей, будь то разработка игр, веб-программирование или анализ данных. Просто расскажи о своих интересах, и он подберет для тебя идеальный путь в IT!
                    </p>
                    <button class="consultation_3" style="margin-top: 20px;" onclick="window.location.href='./consultation.php';">
                        начать консультацию
                    </button>
                </dev>
            </section>
        </section>
        
    </main>

</body>
</html>