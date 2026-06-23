<?php

function checkPostMethod() {
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Разрешен только POST.']);
        exit;
    }
}

function getInputJSON() {
    $inputJSON = file_get_contents('php://input');
    $inputData = json_decode($inputJSON, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Ошибка JSON: ' . json_last_error_msg()]);
        exit;
    }
    return $inputData;
}

function validateData($data) {
    if (!isset($data['user_id']) || !isset($data['title']) || !isset($data['post_text'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Не указаны user_id, title или post_text']);
        exit;
    }
    if (!is_numeric($data['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'user_id должен быть числом']);
        exit;
    }
}

function saveImage($imageData) {
    if (empty($imageData)) {
        return null;
    }
    $extension = 'jpg';
    $cleanData = $imageData;
    if (strpos($imageData, 'base64,') !== false) {
        $parts = explode('base64,', $imageData);
        $cleanData = $parts[1];
        if (strpos($parts[0], 'png') !== false) {
            $extension = 'png';
        } elseif (strpos($parts[0], 'gif') !== false) {
            $extension = 'gif';
        } elseif (strpos($parts[0], 'jpeg') !== false || strpos($parts[0], 'jpg') !== false) {
            $extension = 'jpg';
        }
    }
    $filename = 'img_' . time(). '_' . rand(1, 999) . '.' . $extension;
    $decodedImage = base64_decode($cleanData);
    if ($decodedImage === false) {
        return null;
    }
    $directory = __DIR__ . '/img/';
    $path = $directory . $filename;
    if (file_put_contents($path, $decodedImage)) {
        return './img/' . $filename; 
    }
    return null;
}

function createPost($connection, $userId, $title, $content, $imagePath, $likesCount) {
    $query = 'INSERT INTO post (user_id, title, post_text, image_path, likes_count) 
              VALUES (:user_id, :title, :post_text, :image_path, :likes_count)';
    $statement = $connection->prepare($query);
    $statement->execute([
        ':user_id' => (int)$userId,
        ':title' => trim($title),
        ':post_text' => trim($content),
        ':image_path' => $imagePath,
        ':likes_count' => (int)$likesCount
    ]);
    return $connection->lastInsertId();
}

checkPostMethod();
$data = getInputJSON();
validateData($data);

require_once 'read_bd.php';
$connection = connectDatabase();

$imagePath = saveImage($data['image_path'] ?? null);
$postId = createPost(
    $connection, 
    $data['user_id'], 
    $data['title'],
    $data['post_text'], 
    $imagePath, 
    $data['likes_count'] ?? 0
);

http_response_code(201);
echo json_encode([
    'success' => true,
    'msg' => 'Пост успешно создан',
    'post_id' => $postId,
    'image_path' => $imagePath
]);