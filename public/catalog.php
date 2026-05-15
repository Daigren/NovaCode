<?php require_once __DIR__ . '/../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode — Главная</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="container header-container">
        <div class="logo">
            <span style="font-size: 1.8rem;">◲</span> NovaCode
        </div>
        <nav>
            <ul>
                <li><a href="index.php">главная</a></li>
                <li><a href="catalog.php">курсы</a></li>
                <li><a href="profile.php">настройки</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="search-strip">
    <div class="container search-container">
        <div class="search-input-wrapper">
            <span class="search-icon">⚲</span>
            <input type="text" placeholder="">
        </div>
        <div class="filters-toggle">
            <span style="font-size: 1.2rem; font-weight: bold;">≡</span> фильтры
        </div>
    </div>
</div>

<main class="hero-section">
    <div class="container hero-container">
        
        <div class="hero-form-box">
            <h3>Зарегистрироваться / Войти</h3>
            <form action="api/auth_handler.php" method="POST">
                <div class="input-group">
                    <label>Имя</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-group">
                    <label>Почта</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>
                <div class="input-group">
                    <label>Повторить пароль</label>
                    <input type="password" name="password_repeat" required>
                </div>
                <div class="forgot-password">
                    <a href="#">Забыли пароль?</a>
                </div>
            </form>
        </div>

        <div class="hero-text">
            <h1>NovaCode: Твой<br>квантовый скачок в IT</h1>
            <p>Профессиональная экосистема для<br>изучения современных технологий.<br>Мы превращаем сложные<br>концепции в понятный код, а<br>новичков — в востребованных<br>инженеров.</p>
        </div>

    </div>
    
    <div class="hero-bottom-shape"></div>
</main>

</body>
</html>