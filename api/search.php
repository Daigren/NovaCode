<?php
// Подключаем базу данных
require_once __DIR__ . '/../../includes/db.php';

// Указываем, что ответ будет в формате JSON
header('Content-Type: application/json');

// Получаем параметры из JavaScript
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['cat']) ? trim($_GET['cat']) : '';

// Базовый SQL-запрос
$sql = "SELECT * FROM courses WHERE 1=1";
$params = [];

// Если пользователь ввел текст в поиск
if (!empty($searchQuery)) {
    $sql .= " AND (title LIKE :q OR description LIKE :q)";
    $params[':q'] = '%' . $searchQuery . '%';
}

// Если пользователь выбрал категорию (направление)
if (!empty($category)) {
    $sql .= " AND category = :cat";
    $params[':cat'] = $category;
}

try {
    // Подготавливаем и выполняем запрос
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Возвращаем результат
    echo json_encode($courses);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>