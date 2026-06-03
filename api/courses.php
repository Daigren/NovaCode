<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Сначала войдите в аккаунт"]);
        exit();
    }

    $input = json_decode(file_get_contents('php://input'), true);
    
    $title = trim(htmlspecialchars($input['title'] ?? ''));
    $category_name = trim(htmlspecialchars($input['category'] ?? '')); 
    $type = trim(htmlspecialchars($input['type'] ?? ''));
    $author_id = $_SESSION['user_id'];

    if (empty($title) || empty($category_name) || empty($type)) {
        echo json_encode(["status" => "error", "message" => "Заполните все поля"]);
        exit();
    }

    try {
        $catStmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
        $catStmt->execute(['name' => $category_name]);
        $category = $catStmt->fetch();

        if (!$category) {
            echo json_encode(["status" => "error", "message" => "Выбрана несуществующая категория"]);
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO courses (author_id, category_id, title, type) VALUES (:author_id, :category_id, :title, :type)");
        $stmt->execute([
            'author_id' => $author_id,
            'category_id' => $category['id'],
            'title' => $title,
            'type' => $type
        ]);
        
        echo json_encode(["status" => "success", "message" => "Курс отправлен на проверку модератору!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Ошибка БД: " . $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = trim($_GET['q'] ?? '');
    $cat_name = trim($_GET['cat'] ?? '');

    $query = "
        SELECT courses.*, categories.name AS category_name 
        FROM courses 
        JOIN categories ON courses.category_id = categories.id 
        WHERE courses.status = 'approved'
    ";
    
    $params = [];

    if (!empty($search)) {
        $query .= " AND courses.title LIKE :search";
        $params['search'] = "%$search%";
    }
    if (!empty($cat_name)) {
        $query .= " AND categories.name = :cat_name";
        $params['cat_name'] = $cat_name;
    }

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $allCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $onlineCourses = [];
        $offlineCourses = [];

        foreach ($allCourses as $course) {
            $course['category'] = $course['category_name']; 
            
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