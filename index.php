<?php
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT-Курсы — Платформа для обучения</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 20px; background: #f4f4f4; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #333; }
        .status { padding: 10px; border-radius: 4px; background: #e2fbe5; color: #1e4620; border: 1px solid #c2e7c6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать на платформу курсов!</h1>
        <p class="status">
            <?php if ($pdo): ?>
                ✅ Подключение к базе данных установлено успешно.
            <?php endif; ?>
        </p>
        <p>Это главная страница нашего будущего проекта.</p>
    </div>
</body>
</html>