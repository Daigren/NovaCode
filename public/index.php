<?php require_once __DIR__ . '/../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode — Твой квантовый скачок в IT</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="nova-header">
    <div class="nav-left">
        <a href="index.php" class="logo-container">
            <div class="logo-icon">
                <div class="logo-row">
                    <div class="logo-box-outline"></div>
                    <div class="logo-box-solid"></div>
                </div>
                <div class="logo-row" style="margin-left: 6px;">
                    <div class="logo-box-solid"></div>
                    <div class="logo-box-outline"></div>
                </div>
            </div>
            <span>NovaCode</span>
        </a>
        <nav class="main-nav">
            <a href="index.php">главная</a>
            <a href="catalog.php">курсы</a>
            <a href="profile.php">профиль</a>
            <button class="btn-consult">записаться на консультацию</button>
        </nav>
    </div>
    <div class="nav-right">
        <a href="login.php">войти</a>
    </div>
</header>

<div class="search-strip">
    <div class="search-wrapper">
        <div class="search-input-box">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="">
        </div>
        <button class="filter-btn">
            <span>☰</span> фильтры
        </button>
    </div>
</div>

<section class="hero-section">
    <div class="container hero-layout">
        
        <div class="auth-form-inline">
            <h2>Зарегистрироваться / Войти</h2>
            <form action="../src/api/auth.php" method="POST">
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
                    <input type="password" name="password_confirm" required>
                </div>
                <button type="submit" class="btn-submit">Зарегистрироваться</button>
            </form>
            <div class="auth-switch">
                Уже есть аккаунт? <button>Войти</button>
            </div>
        </div>

        <div class="hero-text">
            <h1>NovaCode: Твой<br>квантовый скачок в IT</h1>
            <p>Профессиональная экосистема для изучения современных технологий. Мы превращаем сложные концепции в понятный код, а новичков — в востребованных инженеров.</p>
        </div>

    </div>
</section>

<section class="popular-section">
    <div class="slanted-header">
        <div class="slanted-left">Самые</div>
        <div class="slanted-right">популярные</div>
    </div>

    <div class="container popular-grid">
        <div class="popular-card">
            <h3>C</h3>
            <div class="card-divider"></div>
            <p>Изучите классический язык программирования С, чтобы понять самые глубокие принципы работы компьютеров и памяти. Курс заложит мощнейший фундамент для разработки системного ПО, драйверов и микроконтроллеров.</p>
        </div>
        <div class="popular-card">
            <h3>C++</h3>
            <div class="card-divider"></div>
            <p>C++ — это язык высокой производительности, который дает программисту полный контроль над системными ресурсами и памятью. Изучение C++ открывает двери к созданию игровых движков, операционных систем и высоконагруженных сервисов.</p>
        </div>
        <div class="popular-card">
            <h3>C#</h3>
            <div class="card-divider"></div>
            <p>Освойте мощный язык C# и платформу .NET для создания корпоративных приложений, API и видеоигр на движке Unity. Этот курс даст вам фундаментальные инженерные знания для успешного старта карьеры в Enterprise-сегменте.</p>
        </div>
    </div>
</section>

</body>
</html>