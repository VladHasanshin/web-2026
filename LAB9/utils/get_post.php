<?php
require_once 'read_bd.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Разрешен только GET.']);
    exit;
}

if (!isset($_GET['postId']) || !is_numeric($_GET['postId'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Некорректный или отсутствующий параметр postId']);
    exit;
}

$postId = (int)$_GET['postId'];
$connection = connectDatabase();

$query = 'SELECT id, post_text, image_path 
          FROM post 
          WHERE id = :id';
$statement = $connection->prepare($query);
$statement->execute([':id' => $postId]);
$post = $statement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    http_response_code(404);
    echo json_encode(['error' => 'Пост не найден']);
    exit;
}

echo json_encode($post);