<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

// 1. ЖЕСТКАЯ ПРОВЕРКА ПРАВ: Пускаем только админов
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Доступ запрещен"]);
    exit();
}

// 2. Логика модерации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];
    $action = $input['action']; // 'approve', 'reject' или 'delete'

    try {
        if ($action === 'approve') {
            $pdo->prepare("UPDATE courses SET status = 'approved' WHERE id = ?")->execute([$course_id]);
            $msg = "Курс опубликован.";
        } elseif ($action === 'reject') {
            $pdo->prepare("UPDATE courses SET status = 'rejected' WHERE id = ?")->execute([$course_id]);
            $msg = "Курс отклонен.";
        } elseif ($action === 'delete') {
            $pdo->prepare("DELETE FROM courses WHERE id = ?")->execute([$course_id]);
            $msg = "Курс удален навсегда.";
        }
        
        echo json_encode(["status" => "success", "message" => $msg]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
}
?>