<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Говорим браузеру, что это API, которое возвращает JSON
header('Content-Type: application/json');

// 1. ДОБАВЛЕНИЕ НОВОГО КУРСА (POST-запрос)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $title = trim(htmlspecialchars($input['title'] ?? ''));
    $category = trim(htmlspecialchars($input['category'] ?? ''));
    $type = trim(htmlspecialchars($input['type'] ?? ''));

    if (empty($title) || empty($category) || empty($type)) {
        echo json_encode(["status" => "error", "message" => "Заполните все поля"]);
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO courses (title, category, type) VALUES (:title, :category, :type)");
        $stmt->execute([
            'title' => $title,
            'category' => $category,
            'type' => $type
        ]);
        echo json_encode(["status" => "success", "message" => "Курс успешно добавлен!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}

// 2. ПОЛУЧЕНИЕ КУРСОВ С ФИЛЬТРАМИ (GET-запрос)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = trim($_GET['q'] ?? '');
    $cat = trim($_GET['cat'] ?? '');

    // Собираем базовый SQL запрос
    $query = "SELECT * FROM courses WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $query .= " AND title LIKE :search";
        $params['search'] = "%$search%";
    }
    if (!empty($cat)) {
        $query .= " AND category = :cat";
        $params['cat'] = $cat;
    }

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $allCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Сортируем курсы по типу
        $onlineCourses = [];
        $offlineCourses = [];

        foreach ($allCourses as $course) {
            if ($course['type'] === 'online') {
                $onlineCourses[] = $course;
            } else {
                $offlineCourses[] = $course;
            }
        }

        echo json_encode([
            "status" => "success",
            "online" => $onlineCourses,
            "offline" => $offlineCourses
        ]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}
?>