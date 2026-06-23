<?php

function connectDatabase(): PDO {
    $dsn = 'mysql:host=127.0.0.1;dbname=blog';
    $user = 'root';
    $password = '';
    try {
        return $pdo = new PDO($dsn, $user, $password);  
    } catch (PDOException $e) {
        die("Ошибка: " . $e->getMessage());
    }
}

function getAllPostsFromDatabase(PDO $connection): array {
    $query = <<<SQL
        SELECT
            p.id, 
            p.title, 
            p.image_path, 
            p.post_text, 
            p.likes_count, 
            p.post_time,
            u.user_name,
            u.avatar_path
        FROM post p
        JOIN user u ON p.user_id = u.id
        ORDER BY p.post_time DESC
    SQL;
    $statement = $connection->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getPostById(PDO $connection, int $postId): ?array {
    $query = <<<SQL
        SELECT
            p.id, 
            p.title, 
            p.image_path, 
            p.post_text, 
            p.likes_count, 
            p.post_time,
            u.user_name,
            u.avatar_path
        FROM post p
        JOIN user u ON p.user_id = u.id
        WHERE p.id = $postId
    SQL;
    $statement = $connection->query($query);
    return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
}

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
    $filename = 'img_' . time() . '_' . rand(1, 999) . '.' . $extension;
    
    $dir = __DIR__ . '/../img/'; 
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    } 

    $decodedData = base64_decode($cleanData);

    return (file_put_contents($dir . $filename, $decodedData) !== false) 
        ? './img/' . $filename 
        : null;
}