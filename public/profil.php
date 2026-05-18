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
        <section class="mainContent_2" id="profilContent">
            <img src="./assets/images/avatar.svg" alt="profile" class="profileImage">

            <h4>Имя пользователя</h4>
            <input type="text" placeholder="Введите имя пользователя" class="profileInput">
        </section>
    </main>

</body>
</html>