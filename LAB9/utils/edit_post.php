<?php
require_once 'read_bd.php';

function validateData($data) {
    if (!isset($data['post_id']) || !isset($data['post_text'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Не указаны post_id или post_text']);
        exit;
    }
    if (!is_numeric($data['post_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'post_id должен быть числом']);
        exit;
    }
}

function updatePost($connection, $postId, $content, $imagePathString) {
    $query = 'UPDATE post 
              SET post_text = :post_text, image_path = :image_path 
              WHERE id = :post_id';
    $statement = $connection->prepare($query);
    return $statement->execute([
        ':post_id' => (int)$postId,
        ':post_text' => trim($content),
        ':image_path' => $imagePathString
    ]);
}

checkPostMethod();
$data = getInputJSON();
validateData($data);

$connection = connectDatabase();

$finalPaths = [];
if (isset($data['existing_images']) && is_array($data['existing_images'])) {
    $finalPaths = $data['existing_images'];
}

if (isset($data['images']) && is_array($data['images'])) {
    foreach ($data['images'] as $base64Data) {
        $path = saveImage($base64Data); 
        if ($path) {
            $finalPaths[] = $path;
        }
    }
}

$imagePathString = implode(',', $finalPaths);
$success = updatePost($connection, $data['post_id'], $data['post_text'], $imagePathString);

if ($success) {
    http_response_code(200);
    echo json_encode(['success' => true, 'msg' => 'Пост успешно обновлен']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Не удалось обновить запись в БД']);
}