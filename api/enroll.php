<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Сначала войдите в аккаунт"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Проверяем, не записан ли он уже
        $check = $pdo->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
        $check->execute([$user_id, $course_id]);
        
        if ($check->fetch()) {
            echo json_encode(["status" => "error", "message" => "Вы уже записаны на этот курс!"]);
            exit();
        }

        // Записываем на курс (progress по умолчанию 0)
        $stmt = $pdo->prepare("INSERT INTO user_courses (user_id, course_id, progress) VALUES (?, ?, 0)");
        $stmt->execute([$user_id, $course_id]);

        echo json_encode(["status" => "success", "message" => "Успешно добавлено в 'Мои курсы'"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
}
?>