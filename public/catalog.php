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
        <a href="./index.php">Главная</a>
        <a href="./catalog.php" style="color: #b4b4b4;">Курсы</a>
        <a href="./profil.php">Профиль</a>
        <button id="consultation" onclick="window.location.href='./consultation.php';">консультация</button>
    </header>

    <main class="container-custom">
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
                            <label class="filter-option"><input type="radio" name="cat" value="" checked><span>Все направления</span></label>
                            <label class="filter-option"><input type="radio" name="cat" value="Python"><span>Python</span></label>
                            <label class="filter-option"><input type="radio" name="cat" value="C++"><span>C++</span></label>
                            <label class="filter-option"><input type="radio" name="cat" value="C#"><span>C#</span></label>
                            <label class="filter-option"><input type="radio" name="cat" value="Java"><span>Java</span></label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?= $message; ?>

        <section class="admin-panel">
            <h2>Добавить новый курс</h2>
            <form action="catalog.php" method="POST">
                <div class="form-group">
                    <label for="title">Название курса</label>
                    <input type="text" id="title" name="title" required placeholder="Например: Основы алгоритмов">
                </div>
                <div class="form-group">
                    <label for="category">Категория</label>
                    <select id="category" name="category" required>
                        <option value="Python">Python</option>
                        <option value="C++">C++</option>
                        <option value="C#">C#</option>
                        <option value="Java">Java</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Тип курса</label>
                    <select id="type" name="type" required>
                        <option value="online">Онлайн-формат</option>
                        <option value="offline">Офлайн-формат</option>
                    </select>
                </div>
                <button type="submit" name="add_course" class="btn-submit">Добавить курс</button>
            </form>
        </section>

        <h1 class="coursesTitle" style="margin-top: 60px;">Онлайн-курсы</h1>
        <section class="mainContent_2">
            <?php if (!empty($onlineCourses)): ?>
                <?php foreach ($onlineCourses as $course): ?>
                    <div class="course-card">
                        <div class="course-badge"><?= htmlspecialchars($course['category']) ?></div>
                        <h3 class="course-title"><?= htmlspecialchars($course['title']) ?></h3>
                        <div class="course-meta">Доступно онлайн</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--text-secondary); grid-column: 1 / -1;">В этой категории пока нет курсов.</p>
            <?php endif; ?>
        </section>

        <h1 class="coursesTitle">Офлайн-курсы</h1>
        <section class="mainContent_2">
            <?php if (!empty($offlineCourses)): ?>
                <?php foreach ($offlineCourses as $course): ?>
                    <div class="course-card">
                        <div class="course-badge"><?= htmlspecialchars($course['category']) ?></div>
                        <h3 class="course-title"><?= htmlspecialchars($course['title']) ?></h3>
                        <div class="course-meta">Очное обучение</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--text-secondary); grid-column: 1 / -1;">В этой категории пока нет курсов.</p>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>