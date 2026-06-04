<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Нет доступа"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $course_id = $_GET['id'] ?? null;
    
    if (!$course_id) {
        echo json_encode(["status" => "error", "message" => "Не указан ID курса"]);
        exit();
    }

    $stmt = $pdo->prepare("SELECT title, content FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {
        echo json_encode(["status" => "success", "course" => $course]);
    } else {
        echo json_encode(["status" => "error", "message" => "Курс не найден"]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'] ?? null;
    $content = $input['content'] ?? '';

    if (!$course_id) {
        echo json_encode(["status" => "error", "message" => "Не указан ID курса"]);
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE courses SET content = ? WHERE id = ?");
        $stmt->execute([$content, $course_id]);
        echo json_encode(["status" => "success", "message" => "Материал успешно сохранен!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}
?>