<?php
require_once 'read_bd.php';

function validateLikeData($data) {
    if (!isset($data['post_id'], $data['action'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Не указаны post_id или action']);
        exit;
    }
    
    if ($data['action'] !== 'add' && $data['action'] !== 'remove') {
        http_response_code(400);
        echo json_encode(['error' => 'Неверное действие. Допустимы только add или remove']);
        exit;
    }
}

function togglePostLike($connection, $postId, $action) {
    if ($action === 'add') {
        $query = 'UPDATE post 
                  SET likes_count = likes_count + 1 
                  WHERE id = :post_id';
    } else {
        $query = 'UPDATE post 
                  SET likes_count = likes_count - 1 
                  WHERE id = :post_id';
    }
    $statement = $connection->prepare($query);
    return $statement->execute([':post_id' => (int)$postId]);
}

function getLikesCount($connection, $postId) {
    $query = 'SELECT likes_count 
              FROM post 
              WHERE id = :post_id';
    $statement = $connection->prepare($query);
    $statement->execute([':post_id' => (int)$postId]);
    
    $post = $statement->fetch(PDO::FETCH_ASSOC);
    return $post ? (int)$post['likes_count'] : 0;
}

checkPostMethod();
$data = getInputJSON();
validateLikeData($data);
$postId = $data['post_id'];
$action = $data['action'];
$connection = connectDatabase();

if (togglePostLike($connection, $postId, $action)) {
    $currentLikes = getLikesCount($connection, $postId);
    http_response_code(200);
    echo json_encode([
        'success' => true, 
        'likes_count' => $currentLikes
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Не удалось обновить лайки в БД']);
}