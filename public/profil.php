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

        // Обработка загрузки аватара
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['avatar']['tmp_name'];
            $fileName = $_FILES['avatar']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'webp'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = 'avatar_' . $user_id . '_' . time() . '.' . $fileExtension;
                $uploadFileDir = './uploads/avatars/';
                
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Получаем старый путь, чтобы удалить файл
                    $checkStmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
                    $checkStmt->execute([$user_id]);
                    $oldAvatarData = $checkStmt->fetch();
                    if ($oldAvatarData && !empty($oldAvatarData['avatar']) && file_exists($oldAvatarData['avatar'])) {
                        unlink($oldAvatarData['avatar']);
                    }
                    
                    $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
                    $stmt->execute(['avatar' => 'uploads/avatars/' . $newFileName, 'id' => $user_id]);
                    $message = "<div style='color: var(--neon-cyan); margin-bottom: 15px;'>Профиль успешно обновлен!</div>";
                } else {
                    $message = "<div style='color: #ff4444; margin-bottom: 15px;'>Ошибка при сохранении файла аватара.</div>";
                }
            } else {
                $message = "<div style='color: #ff4444; margin-bottom: 15px;'>Недопустимый формат файла. Разрешены: JPG, JPEG, PNG, GIF, WEBP.</div>";
            }
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
                <div style="position: relative; display: inline-block; cursor: pointer; margin-bottom: 20px;" onclick="document.getElementById('avatar').click();" title="Нажмите, чтобы изменить фото профиля">
                    <?php 
                    $avatarSrc = !empty($currentUser['avatar']) ? $currentUser['avatar'] : './assets/images/avatar.svg';
                    ?>
                    <img src="<?= htmlspecialchars($avatarSrc) ?>" alt="profile" class="profileImage">
                    <div style="position: absolute; bottom: 5px; right: 5px; background: #000000; border: 1px solid #ffffff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#ffffff';this.querySelector('svg').style.stroke='#000000'" onmouseout="this.style.backgroundColor='#000000';this.querySelector('svg').style.stroke='#ffffff'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    </div>
                </div>

                <?= $message ?>

                <form action="profil.php" method="POST" enctype="multipart/form-data" style="width: 100%; display: flex; flex-direction: column; gap: 10px;">
                    <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                    
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