<?php
require_once '../includes/db.php';
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
    <div class="container">
        <h1>NovaCode</h1>
        <p class="status">
            <?php if ($pdo): ?>
                Подключение к базе данных установлено успешно.
            <?php endif; ?>
        </p>
    </div>
</body>
</html>