<?php
session_start();
header('Content-Type: application/json');

// Если бейджик есть, возвращаем true, если нет - false
if (isset($_SESSION['user_id'])) {
    echo json_encode(["logged_in" => true]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>