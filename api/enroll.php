<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Сначала войдите в аккаунт"]);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'] ?? null;

    if (!$course_id) {
        echo json_encode(["status" => "error", "message" => "Не указан ID курса"]);
        exit();
    }

    try {
        $check = $pdo->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
        $check->execute([$user_id, $course_id]);
        
        if ($check->fetch()) {
            echo json_encode(["status" => "error", "message" => "Вы уже записаны на этот курс!"]);
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO user_courses (user_id, course_id, progress) VALUES (?, ?, 0)");
        $stmt->execute([$user_id, $course_id]);

        echo json_encode(["status" => "success", "message" => "Успешно добавлено в 'Мои курсы'"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("
            SELECT c.id, c.title, cat.name AS category_name, c.type, uc.progress 
            FROM user_courses uc
            JOIN courses c ON uc.course_id = c.id
            JOIN categories cat ON c.category_id = cat.id
            WHERE uc.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['status' => 'success', 'courses' => $courses]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка БД: ' . $e->getMessage()]);
    }
    exit();
}
?>