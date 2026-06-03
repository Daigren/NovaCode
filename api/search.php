<?php
require_once __DIR__ . '/../../includes/db.php';

header('Content-Type: application/json');

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['cat']) ? trim($_GET['cat']) : '';

$sql = "SELECT * FROM courses WHERE 1=1";
$params = [];

if (!empty($searchQuery)) {
    $sql .= " AND (title LIKE :q OR description LIKE :q)";
    $params[':q'] = '%' . $searchQuery . '%';
}

if (!empty($category)) {
    $sql .= " AND category = :cat";
    $params[':cat'] = $category;
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($courses);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>