<?php
require_once 'read_bd.php';

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : null;
$post = null;

if ($postId) {
    $connection = connectDatabase();
    $post = getPostById($connection, $postId);
}

if (!$post) {
    http_response_code(404);
    echo 'Пост не найден. Проверьте параметр postId в адресной строке.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <nav class="sidebar">
        <a href="/LAB7/home.php"><img class="sidebar__icon" width="40" height="40" src="./img/home_icon.png" alt="Home" title="Home"></a>
        <a href="/LAB6/profile"><img class="sidebar__icon" width="40" height="40" src="./img/profile_icon.png" alt="Profile" title="Profile"></a>
        <a href="#"><img class="sidebar__icon" width="40" height="40" src="./img/plus_icon.png" alt="Plus" title="New post"></a>
    </nav>
    <div class="feed">
        <div class="post">
            <div class="user">
                <div class="user-info">
                    <img class="user-info__image" width="32" height="32" src="<?= $post['avatar_path'] ?>" alt="<?= htmlspecialchars($post['user_name']) ?>" title="User title">
                    <p class="user-info__name" title="Username"><?= htmlspecialchars($post['user_name']) ?></p>
                </div>
                <a href="#"><img class="user__edit-icon" width="36" height="36" src="./img/edit_icon.png" alt="Edit" title="Edit"></a>
            </div>
            <img class="post__image" width="474" height="474" src="<?= $post['image_path'] ?>" alt="Post image" title="Post title">
            <div class="reaction">
                <img class="reaction__emoji" width="16" height="16" src="./img/emoji_heart.png" alt="Heart" title="Heart">
                <span class="reaction__emoji-count"><?= $post['likes_count'] ?></span>
            </div>
            <p class="post__text"><?= htmlspecialchars($post['post_text'])?></p>
            <a href="#" class="post__and">ещё</a>
            <p class="post__time"><?= date('d.m.Y H:i', strtotime($post['post_time'])) ?></p>
            <a href="/LAB7/home.php">Вернуться к постам</a>
        </div>
    </div>    
</body>
</html>