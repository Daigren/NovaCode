<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: profil.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = 'Пожалуйста, заполните все поля.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: profil.php");
                exit();
                
            } else {
                $error_message = 'Неверный email или пароль.';
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
    <title>NovaCode - Вход</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/filter.js" defer></script>
    <script src="assets/js/animations.js" defer></script>
    <link rel="icon" type="image/svg+xml" href="assets/images/main.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <img src="./assets/images/iconHeader.svg" alt="icon">
        <a href="./index.">Главная</a>
        <a href="./catalog.html">Курсы</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="./profil.php">Профиль</a>
        <?php else: ?>
            <a href="./register.php">Профиль</a>
        <?php endif; ?>

        <button id="consultation" onclick="window.location.href='./consultation.html';">
            консультация
        </button>
    </header>

    <main class="auth-container">
        <section class="authorization">
            <h2>Вход в аккаунт</h2>

            <?php if (!empty($error_message)): ?>
                <div class="auth-error">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                
                <div class="form-group">
                    <label for="email" class="userInfo">Email</label>
                    <input type="email" id="email" name="email" class="profileInput" autocomplete="off" placeholder="example@mail.ru" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="password" class="userInfo">Пароль</label>
                    <input type="password" id="password" name="password" class="profileInput" autocomplete="off" placeholder="Введите пароль" required>
                </div>

                <button type="submit" name="login" class="button-changes">Войти</button>
            </form>

            <div class="auth-links">
                Нет аккаунта? <a href="register.php" class="login-link">Зарегистрироваться</a>
            </div>
        </section>
    </main>

</body>
</html>