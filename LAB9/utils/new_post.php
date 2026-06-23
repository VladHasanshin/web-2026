<?php
require_once 'read_bd.php';

function validateData($data) {
    if (!isset($data['user_id']) || !isset($data['post_text'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Не указаны user_id или post_text']);
        exit;
    }
    if (!is_numeric($data['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'user_id должен быть числом']);
        exit;
    }
}

function createPost($connection, $userId, $content, $imagePath, $likesCount) {
    $query = 'INSERT INTO post (user_id, title, post_text, image_path, likes_count) 
              VALUES (:user_id, "", :post_text, :image_path, :likes_count)';
    $statement = $connection->prepare($query);
    $statement->execute([
        ':user_id' => (int)$userId,
        ':post_text' => trim($content),
        ':image_path' => $imagePath,
        ':likes_count' => (int)$likesCount
    ]);
    return $connection->lastInsertId();
}

checkPostMethod();
$data = getInputJSON();
validateData($data);

$connection = connectDatabase();
$savedPaths = [];

if (isset($data['images']) && is_array($data['images'])) {
    foreach ($data['images'] as $base64Data) {
        $path = saveImage($base64Data); 
        if ($path) {
            $savedPaths[] = $path;
        }
    }
}

$imagePathString = implode(',', $savedPaths);
$postId = createPost($connection, $data['user_id'], $data['post_text'], $imagePathString, 0);

if ($postId) {
    http_response_code(201);
    echo json_encode(['success' => true, 'post_id' => $postId]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Не удалось создать запись в БД']);
}