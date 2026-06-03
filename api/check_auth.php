<?php
session_start();
error_reporting(0); 

require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    echo json_encode([
        "logged_in" => true,
        "role" => $user['role'] ?? 'user'
    ]);
} else {
    echo json_encode([
        "logged_in" => false,
        "role" => "guest"
    ]);
}
?>