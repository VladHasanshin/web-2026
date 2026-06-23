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
?>