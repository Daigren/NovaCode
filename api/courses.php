<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Говорим браузеру, что возвращаем JSON
header('Content-Type: application/json');

// ==========================================
// 1. ДОБАВЛЕНИЕ НОВОГО КУРСА (POST-запрос)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Защита: добавлять курсы могут только авторизованные пользователи
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Сначала войдите в аккаунт"]);
        exit();
    }

    $input = json_decode(file_get_contents('php://input'), true);
    
    $title = trim(htmlspecialchars($input['title'] ?? ''));
    $category_name = trim(htmlspecialchars($input['category'] ?? '')); // Название, например "Python"
    $type = trim(htmlspecialchars($input['type'] ?? ''));
    $author_id = $_SESSION['user_id'];

    if (empty($title) || empty($category_name) || empty($type)) {
        echo json_encode(["status" => "error", "message" => "Заполните все поля"]);
        exit();
    }

    try {
        // Шаг А: Ищем ID категории в базе по её названию
        $catStmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
        $catStmt->execute(['name' => $category_name]);
        $category = $catStmt->fetch();

        if (!$category) {
            echo json_encode(["status" => "error", "message" => "Выбрана несуществующая категория"]);
            exit();
        }

        // Шаг Б: Записываем курс в базу (статус 'pending' БД поставит сама)
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

// ==========================================
// 2. ПОЛУЧЕНИЕ КУРСОВ (GET-запрос)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = trim($_GET['q'] ?? '');
    $cat_name = trim($_GET['cat'] ?? '');

    // Используем JOIN, чтобы склеить таблицы и получить имя категории вместо её ID.
    // ГЛАВНОЕ УСЛОВИЕ: Показываем только status = 'approved'
    $query = "
        SELECT courses.*, categories.name AS category_name 
        FROM courses 
        JOIN categories ON courses.category_id = categories.id 
        WHERE courses.status = 'approved'
    ";
    
    $params = [];

    // Добавляем фильтры, если они есть
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
            // Фронтенд ждет ключ 'category', поэтому отдаем ему то, что достали через JOIN
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