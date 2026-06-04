<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit(); 
}

require_once __DIR__ . '/../includes/db.php';

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_username = trim(htmlspecialchars($_POST['username']));
    $new_password = $_POST['new_password'];

    try {
        if (!empty($new_username)) {
            $stmt = $pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
            $stmt->execute(['username' => $new_username, 'id' => $user_id]);
            $_SESSION['username'] = $new_username; 
            $message = "<div style='color: var(--neon-cyan); margin-bottom: 15px;'>Данные успешно обновлены!</div>";
        }

        if (!empty($new_password)) {
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
            $stmt->execute(['hash' => $password_hash, 'id' => $user_id]);
            $message = "<div style='color: var(--neon-cyan); margin-bottom: 15px;'>Пароль успешно изменен!</div>";
        }
        
    } catch (PDOException $e) {
        $message = "<div style='color: #ff4444; margin-bottom: 15px;'>Ошибка базы данных: " . $e->getMessage() . "</div>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$currentUser = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCode - Профиль</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <script src="assets/js/header.js" defer></script>
    <script src="assets/js/filter.js" defer></script>
    <script src="assets/js/avatar.js" defer></script>
    <script src="assets/js/my_courses.js" defer></script>
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
        
        <a href="#" id="navProfileLink" style="opacity: 0; transition: opacity 0.3s ease;">Профиль</a>

        <button id="consultation" onclick="window.location.href='./consultation.php';">
            консультация
        </button>
    </header>

    <main id="mainContentProfil">
        <section class="mainContent_3 fade-element">
            <section id="profilContent">
                <img src="./assets/images/avatar.svg" alt="profile" class="profileImage">

                <?= $message ?>

                <form action="profil.php" method="POST" style="width: 100%; display: flex; flex-direction: column; gap: 10px;">
                    
                    <div>
                        <h4 class="userInfo">Имя</h4>
                        <input type="text" name="username" placeholder="Введите имя пользователя" class="profileInput" value="<?= htmlspecialchars($currentUser['username'] ?? '') ?>" required>
                    </div>

                    <div>
                        <h4 class="userInfo">Email</h4>
                        <input type="email" class="profileInput" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" readonly style="opacity: 0.6; cursor: not-allowed;" title="Email нельзя изменить">
                    </div>

                    <div>
                        <h4 class="userInfo">Новый пароль</h4>
                        <input type="password" name="new_password" class="profileInput" placeholder="******">
                    </div>

                    <div>
                        <h4 class="userInfo">Био</h4>
                        <textarea name="bio" maxlength="200" placeholder="Добавить описание" class="bioInput"><?= htmlspecialchars($currentUser['bio'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" name="update_profile" class="button-changes">
                        Сохранить изменения
                    </button>
                </form>

                <?php if (isset($currentUser['role']) && $currentUser['role'] === 'admin'): ?>
                    <div class="admin-panel-card">
                        <button onclick="window.location.href='admin.html'" class="button-changes">
                            Открыть панель модерации
                        </button>
                    </div>
                <?php endif; ?>

                <button onclick="window.location.href='logout.php';" class="btn-logout">
                    Выйти
                </button>

            </section>

            <section id="myCoursesSection">
                <h2>Мои курсы</h2>
                <div class="myCourses"></div>
            </section>
            
        </section>
    </main>

</body>
</html>