<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Доступ запрещен"]);
    exit();
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "У вас нет прав администратора!"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("
            SELECT courses.*, categories.name AS category_name, users.username AS author_name 
            FROM courses 
            JOIN categories ON courses.category_id = categories.id 
            JOIN users ON courses.author_id = users.id
            WHERE courses.status = 'pending'
        ");
        $pendingCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(["status" => "success", "courses" => $pendingCourses]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $course_id = $input['course_id'];
    $action = $input['action']; 

    try {
        if ($action === 'approve') {
            $pdo->prepare("UPDATE courses SET status = 'approved' WHERE id = ?")->execute([$course_id]);
            $msg = "Курс успешно добавлен в каталог!";
        } else {
            $pdo->prepare("UPDATE courses SET status = 'rejected' WHERE id = ?")->execute([$course_id]);
            $msg = "Курс отклонен.";
        }
        echo json_encode(["status" => "success", "message" => $msg]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}
?>