<?php
session_start();

require_once __DIR__ . '/../includes/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    $username = trim(htmlspecialchars($_POST['username']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($email) || empty($password)) {
        $error_message = 'Пожалуйста, заполните все поля.';
    } elseif ($password !== $password_confirm) {
        $error_message = 'Пароли не совпадают.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            
            if ($stmt->fetch()) {
                $error_message = 'Пользователь с таким email уже зарегистрирован.';
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $insertStmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
                $insertStmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => $password_hash
                ]);

                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;

                header("Location: profil.php");
                exit(); 
            }
        } catch (PDOException $e) {
            $error_message = 'Ошибка базы данных: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode - Регистрация</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/filter.js" defer></script>
    <script src="assets/js/auth.js" defer></script>
    <script src="assets/js/animations.js" defer></script>
    <link rel="icon" type="image/svg+xml" href="assets/images/main.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">
    
</head>
<body>

    <header>
        <img src="./assets/images/iconHeader.svg" alt="icon">
        <a href="./index.html">Главная</a>
        <a href="./catalog.html">Курсы</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="./profil.php">Профиль</a>
        <?php else: ?>
            <a href="./register.php">Профиль</a>
        <?php endif; ?>

        <button id="consultation" onclick="window.location.href='./consultation.php';">
            консультация
        </button>
    </header>

    <main id="mainContentProfil" class="auth-container">
        <section class="mainContent_3">
            <h2>Регистрация</h2>

            <?php if (!empty($error_message)): ?>
                <div class="auth-error">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" placeholder="Придумайте никнейм" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@mail.ru" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="Минимум 6 символов" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Подтверждение пароля</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Повторите пароль" required>
                </div>

                <button type="submit" name="register" class="btn-auth">Создать аккаунт</button>
            </form>

            <div class="auth-links">
                Уже есть аккаунт? <a href="login.php">Войти</a>
            </div>
        </section>
    </main>

</body>
</html>